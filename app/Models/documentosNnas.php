<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentosNnas extends Model
{
    use HasFactory;

    protected $table = 'documentos_nnas';
    protected $fillable = [
        'nna_id',
        'nombre',
        'tipo',
        'fecha_emision',
        'descripcion',
        'estado',
        'url',
    ];
    //relaciones
    public function evaluacionesPsicologicas()
    {
        return $this->hasMany(evaluacionesPsicologicas::class, 'evaluacionesPsicologicas.id');
    }


     public function evaluacionesMedicas()
    {
        return $this->hasMany(evaluacionesMedicas::class, 'evaluacionesMedicas.id');
    }
    // Relación: un documento pertenece a un niño (nna)
    public function nna()
    {
        return $this->belongsTo(Nnas::class, 'nna_id');
    }
}
