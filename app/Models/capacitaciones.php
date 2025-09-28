<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class capacitaciones extends Model
{
    use HasFactory;

    protected $table = 'capacitaciones'; // Asegúrate de que el nombre de la tabla esté correctamente definido

    // Atributos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'duracion',
        'modalidad',
        'institucion',
        'direccion',
        'estado',
    ];
    // Relación con sesiones
    public function sesiones()
    {
        return $this->hasMany(sesiones::class, 'capacitacion_id');
    }
}

