<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Método para mostrar la lista de proyectos asignados al usuario
    public function index()
    {
        if (auth()->user()->rol_id == 1) {
            // Si el usuario es administrador, obtiene TODOS los proyectos
            $projects = Project::all();
        } else {
            // Si es usuario normal, solo ve los proyectos en los que está asignado
            $projects = auth()->user()->projects;
        }

        return view('projects.index', compact('projects'));
    }

    // Método para mostrar los detalles de un proyecto específico
    public function show(Project $project)
    {
        if (auth()->user()->rol_id != 1 && !$project->users->contains(auth()->user()->id)) {
            return redirect()->back();
        }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        if (auth()->user()->rol_id != 1) {
            return redirect()->back();
        }

        $users = User::orderBy('id')->paginate(15);
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        // Crear el proyecto
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'created_by' => Auth::id(),
        ]);

        // Asignar usuarios al proyecto
        $project->users()->attach($request->users);

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto creado y usuarios asignados.');
    }

    public function edit(Project $project)
    {
        if (auth()->user()->rol_id != 1 && !$project->users->contains(auth()->user()->id)) {
            return redirect()->back();
        }

        $users = User::orderBy('name')->get();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        if (auth()->user()->rol_id != 1 && !$project->users->contains(auth()->user()->id)) {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id'
        ]);

        // Actualizar los datos del proyecto
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        // Sincronizar usuarios asignados
        $project->users()->sync($request->users);

        return redirect()->route('projects.show', $project->id)->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect()->back();
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    }
}
