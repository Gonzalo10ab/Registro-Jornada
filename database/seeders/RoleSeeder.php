<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'description' => 'Administrador del sistema'],
            ['id' => 2, 'name' => 'Usuario', 'description' => 'Usuario con permisos limitados'],
        ]);
    }
}

