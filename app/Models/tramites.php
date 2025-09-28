<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tramites extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'institucion',
        'tipo',
        'estado',
    ];

    public function tramiteAdoptantes()
    {
        return $this->hasMany(Tramites_Adoptantes::class);
    }

     public function adoptantes()
    {
        return $this->belongsToMany(Adoptantes::class, 'tramite_adoptante')
                    ->withPivot('documento_adoptante_id')
                    ->withTimestamps();
    }
}
