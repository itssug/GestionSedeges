<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluacionesPsicologicas extends Model
{
    use HasFactory;
    //relaciones
    public function nna()
    {
        return $this->belongsTo(Nnas::class, 'nna_id');
    }
    public function personalSedeges()
    {
        return $this->belongsTo(personalSedeges::class, 'personal_sedeges_id');
    }

    public function documentoNna()
{
    return $this->belongsTo(DocumentosNnas::class, 'documentos_nna_id');
}



    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nna_id',
        'personal_sedeges_id',
        'fecha',
        'diagnostico',
        'recomendaciones',
        'observaciones',
        'documentos_nna_id',
    ];
    // Definir la tabla asociada al modelo
    protected $table = 'evaluaciones_psicologicas';

}
