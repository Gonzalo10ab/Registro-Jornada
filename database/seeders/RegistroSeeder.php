<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registro;
use App\Models\User;
use Carbon\Carbon;

class RegistroSeeder extends Seeder
{
    public function run()
    {
        $usuarios = User::all();

        foreach ($usuarios as $usuario) {
            for ($i = 0; $i < 30; $i++) { // Crea 5 registros por usuario
                $fecha = Carbon::now()->subDays(rand(1, 30)); // Día aleatorio en el último mes
                
                $entrada = $fecha->copy()->setHour(rand(7, 10))->setMinute(rand(0, 59));
                $salida = $entrada->copy()->addHours(rand(4, 8))->addMinutes(rand(0, 59));

                Registro::create([
                    'user_id' => $usuario->id,
                    'entry_time' => $entrada,
                    'departure_time' => $salida,
                ]);
            }
        }
    }
}

