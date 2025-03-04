<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Relación: Un rol tiene muchos usuarios.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}

