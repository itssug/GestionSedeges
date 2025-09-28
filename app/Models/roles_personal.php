<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles_personal extends Model
{
    use HasFactory;

    protected $table = 'roles_personals'; // nombre correcto de la tabla

    protected $fillable = ['nombre_rol_per']; 

    public function users()
    {
        return $this->hasMany(personalSedeges::class, 'roles_personal_id');
    }
}
