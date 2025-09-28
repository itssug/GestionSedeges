<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asistencias extends Model
{
    use HasFactory;

    // Para permitir la asignación masiva
    protected $fillable = [
        'asistencia',
        'sesion_id',
        'adoptante_id',
    ];
    // Relación con sesión
    public function sesiones()
    {
        return $this->belongsTo(sesiones::class, 'sesion_id');
    }
    // Relación con adoptante
    public function adoptantes()
    {
        return $this->belongsTo(adoptantes::class, 'adoptante_id');
    }

    public function adoptante()
    {
        return $this->belongsTo(adoptantes::class, 'adoptante_id');
    }

    public function sesion()
    {
        return $this->belongsTo(sesiones::class, 'sesion_id');
    }
}
