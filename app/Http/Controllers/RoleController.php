<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Muestra todos los roles.
     */
    public function index()
    {
        return response()->json(Role::all(), 200);
    }
}

