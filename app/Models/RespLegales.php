<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespLegales extends Model
{
    use HasFactory;

    protected $fillable = [
        'direccion_oficina',
        'especialidad',
        'estado',
        'horarios_atencion',
        'user_id',
        'tipo_resp_legales_id',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el tipo de responsable legal
    public function tipoRespLegal()
    {
        return $this->belongsTo(TipoRespLegales::class, 'tipo_resp_legales_id');
    }
}
