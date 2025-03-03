<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gonzalo',
            'surname' => 'Martínez',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Contraseña segura
            'rango' => 'Administrador',
            'rol_id' => 1, // Admin
            'is_active' => false
        ]);

        User::factory(30)->create();
    }
}

