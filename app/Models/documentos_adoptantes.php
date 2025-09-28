<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos_Adoptantes extends Model
{
    protected $table = 'documentos_adoptantes';

    public function tramiteAdoptantes()
    {
        return $this->hasMany(Tramites_Adoptantes::class);
    }
}
