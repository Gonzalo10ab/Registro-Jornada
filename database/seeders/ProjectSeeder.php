<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los usuarios
        $users = User::all();

        // Si no hay usuarios, salir
        if ($users->isEmpty()) {
            $this->command->info('No hay usuarios en la base de datos. Primero crea usuarios.');
            return;
        }

        // Crear 10 proyectos falsos
        Project::factory(10)->create()->each(function ($project) use ($users) {
            // Asignar un creador aleatorio al proyecto
            $creator = $users->random();
            $project->update(['created_by' => $creator->id]);

            // Asignar entre 1 y 5 usuarios aleatorios al proyecto (incluyendo al creador)
            $assignedUsers = $users->random(rand(1, 5))->pluck('id');
            $project->users()->attach($assignedUsers);
        });
    }
}
