<?php

use App\Models\Project;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegistroController;

// Rutas de autenticación (Laravel Breeze)
require __DIR__.'/auth.php';

// Redirigir dashboard a la página principal
Route::get('/dashboard', fn() => redirect()->route('index'))->name('dashboard');

// Rutas protegidas: solo accesibles para usuarios autenticados
Route::middleware('auth')->group(function () {

    // Página principal
    Route::get('/', fn() => view('index'))->name('index');

    // Historial de registros (usuarios normales y administradores viendo otro usuario)
    Route::prefix('historial')->controller(RegistroController::class)->group(function () {
        Route::get('/{id?}', 'historial')->name('historial');
        Route::get('/pdf/{id?}', 'exportarPDF')->name('historial.pdf');
    });
    
    // Registro de entrada y salida
    Route::prefix('registro')->controller(RegistroController::class)->group(function () {
        Route::post('/entrada', 'entrada')->name('entrada');
        Route::post('/salida', 'salida')->name('salida');
    });

    Route::prefix('proyectos')->controller(ProjectController::class)->group(function () {
        Route::get('/', 'index')->name('projects.index'); // Lista de proyectos asignados al usuario
        Route::get('/{project}', 'show')->name('projects.show'); // Detalle de un proyecto específico
    });

    // Gestión del perfil
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    // Rutas de administrador (solo accesibles para rol_id = 1)
    Route::middleware([AdminMiddleware::class])->prefix('admin')->controller(AdminController::class)->group(function () {
        Route::get('/usuarios', 'index')->name('admin.usuarios');
        Route::post('/usuarios/crear', 'crearUsuario')->name('admin.usuarios.store');
        Route::get('/usuarios/{id}/editar', 'editarUsuario')->name('admin.usuarios.editar');
        Route::post('/usuarios/{id}/actualizar', 'actualizarUsuario')->name('admin.usuarios.actualizar');
        Route::delete('/usuarios/{id}', 'eliminarUsuario')->name('admin.usuarios.eliminar');
    
        // Descargar historial de un usuario o de varios seleccionados en PDF
        Route::get('/usuarios/{id}/pdf', 'exportarPDFUsuario')->name('admin.usuarios.pdf');
        Route::post('/usuarios/pdf', 'exportarPDFMasivo')->name('admin.usuarios.pdf-masivo');

        // Rutas de administración de proyectos
        Route::controller(ProjectController::class)->group(function () {
            Route::get('/proyectos', 'index')->name('admin.projects.index'); // Lista de todos los proyectos
            Route::get('/proyectos/crear', 'create')->name('admin.projects.create'); // Formulario de creación
            Route::post('/proyectos/crear', 'store')->name('admin.projects.store');  // Guardar proyecto
            Route::get('/proyectos/{project}/editar', 'edit')->name('admin.projects.edit'); // Editar proyecto
            Route::post('/proyectos/{project}/actualizar', 'update')->name('admin.projects.update'); // Guardar edición
            Route::delete('/proyectos/{project}', 'destroy')->name('admin.projects.destroy'); // Eliminar proyecto
        });
    });    
    

});
