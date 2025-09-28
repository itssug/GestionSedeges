<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluacionesMedicas extends Model
{
    use HasFactory;

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

   
    protected $fillable = [
    'nna_id',
    'personal_sedeges_id',
    'diagnostico',
    'tratamiento',
    'observaciones',
    'fecha',
    'documentos_nna_id', // <- Asegúrate de incluir este campo
];
}
