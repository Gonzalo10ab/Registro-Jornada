<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();
    
        // Aplicar filtro de búsqueda solo si tiene valor
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'LIKE', "%$buscar%")
                  ->orWhere('surname', 'LIKE', "%$buscar%")
                  ->orWhere('email', 'LIKE', "%$buscar%");
            });
        }
    
        // Aplicar filtro por rol solo si tiene valor
        if ($request->filled('rol')) {
            $query->where('rol_id', $request->rol);
        }
    
        // Obtener usuarios paginados
        $usuarios = $query->paginate(10)->appends(request()->query());
    
        // Verificar si la solicitud es AJAX
        if ($request->ajax()) {
            if ($usuarios->isEmpty()) {
                return response()->json(['html' => '<p class="text-gray-500 dark:text-gray-300 text-center">No se encontraron resultados.</p>']);
            }
    
            return response()->json(['html' => view('admin.partials.usuarios-table', compact('usuarios'))->render()]);
        }
    
        return view('admin.index', compact('usuarios'));
    }

    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);
    
        if ($usuario->rol_id === 1) {
            return response()->json(['success' => false, 'message' => 'No puedes eliminar a un administrador.']);
        }
    
        $usuario->delete();
    
        return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente.']);
    }
    

    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.editar-usuario', compact('usuario', 'roles'));
    }

    public function actualizarUsuario(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => [
                'nullable',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'rol_id' => 'required|exists:roles,id',
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos: una mayúscula, una minúscula, un número y un carácter especial (@$!%*?&).'
        ]);
    
        $usuario->name = $request->name;
        $usuario->surname = $request->surname;
        $usuario->email = $request->email;
        $usuario->rol_id = $request->rol_id;
    
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
    
        $usuario->save();
    
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente.']);
        }
    
        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }
    
    public function crearUsuario(Request $request)
    {
        // Validar con los nombres correctos del formulario
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'rol_id' => 'nullable|integer|exists:roles,id',
        ]);
    
        // Crear usuario con los datos correctos
        $usuario = User::create([
            'name' => $request->nombre ?? 'Usuario', // Ajustado a 'nombre'
            'surname' => $request->apellidos ?? 'Predeterminado', // Ajustado a 'apellidos'
            'email' => $request->email ?? 'default' . time() . '@gmail.com',
            'password' => Hash::make($request->password ?? 'password123'),
            'rol_id' => $request->rol_id ?? 2, // Usuario normal por defecto
        ]);
    
        return redirect()->route('admin.usuarios')->with('success', 'Usuario creado correctamente.');
    }
    
    

    public function exportarPDFMasivo(Request $request)
    {
        // Depuración: Ver si los datos llegan correctamente
        if (!$request->has('usuarios') || empty($request->usuarios)) {
            return redirect()->route('admin.usuarios')->with('error', 'Debes seleccionar al menos un usuario.');
        }

        $usuarios = User::with('registros')->whereIn('id', $request->usuarios)->get();

        if ($usuarios->isEmpty()) {
            return redirect()->route('admin.usuarios')->with('error', 'Los usuarios seleccionados no existen.');
        }

        foreach ($usuarios as $usuario) {
            $this->calcularHorasTrabajadas($usuario->registros);
        }

        $pdf = Pdf::loadView('admin.historial_pdf_multiple', compact('usuarios'));

        return $pdf->download('Registros_Horas_Usuarios.pdf');
    }

    private function calcularHorasTrabajadas($registros)
    {
        foreach ($registros as $registro) {
            if ($registro->departure_time) {
                $entry = \Carbon\Carbon::parse($registro->entry_time);
                $departure = \Carbon\Carbon::parse($registro->departure_time);
                $horas = $entry->diff($departure)->h;
                $minutos = $entry->diff($departure)->i;
                $registro->horas_trabajadas = $horas + ($minutos / 60); // Guardar en decimal

            } else {
                $registro->horas_trabajadas = '---';
            }
        }
    }
}
