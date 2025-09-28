<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nnas extends Model
{
    use HasFactory;
    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'cod_nna',
        'tipo_identificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'fecha_nac',
        'sexo',
        'nacionalidad',
        'situacion_juridica',
        'nivel_educativo',
        'ruta_foto',
        'motivo_ingreso',
        'fecha_ingreso',
        'fecha_salida',
        'observaciones',
        'discapacidad',
        'tipo_discapacidad',
        'centro_id',
        'estado',];

        public function centro()
        {
            return $this->belongsTo(centros::class);
        }

        public function documentosNnas()
    {
        return $this->hasOne(documentosNnas::class);
    }
}
