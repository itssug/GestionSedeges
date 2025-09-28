<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adoptantes extends Model
{
    use HasFactory;

    // Para permitir la asignación masiva
    protected $fillable = [
        'ruta_foto',
        'pais',
        'nacionalidad',
        'estado_civil',
        'nivel_educativo',
        'ocupacion',
        'ingresos_mensuales',
        'user_id',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asistencias()
    {
        return $this->hasMany(asistencias::class, 'adoptante_id');
    }

     public function tramiteAdoptantes()
    {
        return $this->hasMany(Tramites_Adoptantes::class);
    }

    public function tramites()
    {
        return $this->belongsToMany(Tramites::class, 'tramite_adoptante')
                    ->withPivot('documento_adoptante_id')
                    ->withTimestamps();
    }
}

