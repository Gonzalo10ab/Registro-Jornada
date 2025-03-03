<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Registra un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
            'rango' => 'required|string|max:50',
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar contraseña
            'rango' => $request->rango,
            'rol_id' => $request->rol_id,
            'is_active' => false
        ]);

        return response()->json($user, 201);
    }

    /**
     * Muestra un usuario por ID.
     */
    public function show($id)
    {
        return response()->json(User::findOrFail($id), 200);
    }
}

