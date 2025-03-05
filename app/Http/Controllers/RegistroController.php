<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\RegistroNotificacionMarkdown;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // Importamos el modelo User
use App\Models\Registro; // Importamos el modelo Registro
use Illuminate\Http\Request; // Importamos la clase Request para manejar las solicitudes HTTP

class RegistroController extends Controller
{
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $radioTierra = 6371000; // Radio de la Tierra en metros
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $radioTierra * $c;
    }

    /**
     * Registrar entrada.
     * Este método permite registrar la hora de entrada de un usuario.
     */
    // public function entrada(Request $request)
    // {
    //     $request->validate([
    //         'latitude' => 'required|numeric',
    //         'longitude' => 'required|numeric',
    //     ]);

    //     $user = auth()->user();

    //     if ($user->is_active) {
    //         return redirect()->back()->with('error', 'Ya tiene una entrada registrada.');
    //     }

    //     // Coordenadas de la empresa (cámbialas por las reales)
    //     $empresaLat = 37.8830848;
    //     $empresaLon = -4.7808512;

    //     // Calcular distancia
    //     $distancia = $this->calcularDistancia($empresaLat, $empresaLon, $request->latitude, $request->longitude);
    //             if ($distancia > 200) {
    //         return redirect()->back()->with('error', 'Debe estar cerca de la empresa para fichar.');
    //     }

    //     $registro = Registro::create([
    //         'user_id' => $user->id,
    //         'entry_time' => now()
    //     ]);

    //     $user->is_active = true;
    //     $user->save();
    //     Mail::to($user->email)->queue(new RegistroNotificacionMarkdown($user, 'entrada'));

    //     return redirect()->back()->with('success', 'Entrada registrada correctamente.');
    // }
    public function entrada(Request $request)
    {
        \Log::info('Datos recibidos en la solicitud:', $request->all());
    
        return response()->json([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
    }
    
    /**
     * Registrar salida.
     */
    public function salida(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = auth()->user();

        if (!$user->is_active) {
            return redirect()->back()->with('error', 'No tienes una entrada activa.');
        }

        // Coordenadas de la empresa (cámbialas por las reales)
        $empresaLat = 37.8830848;
        $empresaLon = -4.7808512;

        // Calcular distancia
        $distancia = $this->calcularDistancia($empresaLat, $empresaLon, $request->latitude, $request->longitude);
        
        if ($distancia > 200) {
            return redirect()->back()->with('error', 'Debe estar cerca de la empresa para fichar.');
        }

        $registro = Registro::where('user_id', $user->id)
            ->whereNull('departure_time')
            ->orderBy('entry_time', 'desc')
            ->first();

        if (!$registro) {
            return redirect()->back()->with('error', 'No tienes una entrada activa.');
        }

        $registro->departure_time = now();
        $registro->save();

        $user->is_active = false;
        $user->save();
        Mail::to($user->email)->queue(new RegistroNotificacionMarkdown($user, 'salida'));

        return redirect()->back()->with('success', 'Salida registrada correctamente.');
    }

    public function historial($id = null)
    {
        // Si hay un ID, obtenemos el usuario correspondiente, si no, tomamos el usuario autenticado
        $usuario = $id ? User::findOrFail($id) : auth()->user();

        // Si un usuario normal intenta ver el historial de otro usuario, bloqueamos el acceso
        if ($id && auth()->user()->rol_id != 1) {
            return redirect('/')->with('error', 'Acceso denegado.');
        }

        // Obtener los registros paginados
        $registros = $usuario->registros()->orderBy('entry_time', 'desc')->paginate(10);

        // Calcular las horas trabajadas para cada registro
        $registros->getCollection()->transform(function ($registro) {
            $registro->horas_trabajadas = $registro->calcularHorasTrabajadas();
            return $registro;
        });

        // Calcular total de horas trabajadas para TODOS (no solo admin)
        $totalHoras = 0;
        $totalMinutos = 0;

        $usuario->registros->each(function ($registro) use (&$totalHoras, &$totalMinutos) {
            if ($registro->entry_time && $registro->departure_time) {
                $entrada = Carbon::parse($registro->entry_time);
                $salida = Carbon::parse($registro->departure_time);
                $diferencia = $entrada->diff($salida);

                $totalHoras += $diferencia->h;
                $totalMinutos += $diferencia->i;
            }
        });

        // Convertir los minutos extra en horas
        $totalHoras += intdiv($totalMinutos, 60);
        $totalMinutos = $totalMinutos % 60;

        // Asignar al usuario los valores calculados
        $usuario->total_horas = $totalHoras;
        $usuario->total_minutos = $totalMinutos;

        // Retornar la vista correcta según el usuario
        return view($id ? 'admin.informe' : 'historial', compact('usuario', 'registros'));
    }

    public function exportarPDF($id = null)
    {
        // Determinar el usuario (si es admin, obtiene otro usuario; si no, obtiene el suyo)
        $usuario = $id ? User::findOrFail($id) : auth()->user();

        // Si un usuario normal intenta ver el historial de otro usuario, bloqueamos el acceso
        if ($id && auth()->user()->rol_id != 1) {
            return redirect('/')->with('error', 'Acceso denegado.');
        }

        // Obtener los registros del usuario y calcular las horas trabajadas
        $registros = $usuario->registros()->orderBy('entry_time', 'desc')->get();
        $registros = $this->calcularHorasTrabajadas($registros);

        // Generar el PDF con la vista reutilizable
        $pdf = Pdf::loadView('historial_pdf', compact('usuario', 'registros'));

        return $pdf->download('Registro_horas_' . $usuario->name . '.pdf');
    }

    private function calcularHorasTrabajadas($registros)
    {
        foreach ($registros as $registro) {
            if ($registro->departure_time) {
                $entry = Carbon::parse($registro->entry_time);
                $departure = Carbon::parse($registro->departure_time);
                $horas = $entry->diffInHours($departure);
                $minutos = $entry->diffInMinutes($departure) % 60;
                $registro->horas_trabajadas = $horas + ($minutos / 60); // Guardar en número decimal
            } else {
                $registro->horas_trabajadas = 0;
            }
        }
        return $registros;
    }
}
