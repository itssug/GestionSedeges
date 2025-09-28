<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name',
    'apellidos',
    'cod_usu',
    'ruta_foto',
    'contacto',
    'direccion',
    'estado_usu',
    'fecha_nac',
    'identificacion',
    'rol_id',
    'email',
    'password',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function adoptante()
    {
        return $this->hasOne(adoptantes::class);
    }

    public function RespLegales()
    {
        return $this->hasOne(RespLegales::class);
    }

    public function rol()
    {
        return $this->belongsTo(roles::class, 'rol_id');
    }
    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return $this->rol->nombre_rol ?? 'Sin rol';
    }


    public function adminlte_profile_url()
    {
        return 'profile/username';
    }
}
