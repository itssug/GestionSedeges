<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Tramites_Adoptantes extends Pivot
{
    protected $table = 'tramites_adoptantes';

    public function tramite()
    {
        return $this->belongsTo(Tramites::class);
    }

    public function adoptante()
    {
        return $this->belongsTo(Adoptantes::class);
    }

    public function documentoAdoptante()
    {
        return $this->belongsTo(Documentos_Adoptantes::class);
    }
}
