<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Registro extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'entry_time', 'departure_time'];
    protected $dates = ['entry_time', 'departure_time']; // Definimos los campos como fechas

    /**
     * Relación: Un registro pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function calcularHorasTrabajadas()
    {
        if ($this->entry_time && $this->departure_time) {
            $entrada = Carbon::parse($this->entry_time);
            $salida = Carbon::parse($this->departure_time);
            $diferencia = $entrada->diff($salida);
    
            // Asegurar dos dígitos en horas y minutos
            $horas = str_pad($diferencia->h, 2, '0', STR_PAD_LEFT);
            $minutos = str_pad($diferencia->i, 2, '0', STR_PAD_LEFT);
    
            return "{$horas}h {$minutos}min";
        }
    
        return '---';
    }
    
}
