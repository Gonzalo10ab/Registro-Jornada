<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'due_date', 'created_by'];

    // Relación: Un proyecto pertenece a un creador (usuario)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación: Un proyecto tiene muchos usuarios asignados
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
    }
}
