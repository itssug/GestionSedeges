<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sesiones extends Model
{
    use HasFactory;
    // Para permitir la asignación masiva
    protected $fillable = [
        'tema',
        'fecha',
        'duracion',
        'capacitacion_id',
        'hora_inicio',
        'hora_fin',
    ];
    // Relación con capacitacion
    public function capacitacion()
    {
        return $this->belongsTo(capacitaciones::class, 'capacitacion_id');
    }
    // Relación con asistencias
    public function asistencias()
    {
        return $this->hasMany(asistencias::class, 'sesion_id');
    }
}
