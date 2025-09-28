<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personalSedeges extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',            
        'especialidad',
        'area',
        'fecha_ingreso',
        'horario_laboral',
        'roles_personal_id',
        'estado',
        'foto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evaluacionesPsicologicas()
    {
        return $this->hasMany(evaluacionesPsicologicas::class, 'evaluacionesPsicologicas_id');
    }

    // En el modelo personalSedeges.php
    public function rolesPersonal()
    {
        return $this->belongsTo(roles_personal::class, 'roles_personal_id');
    }
}
