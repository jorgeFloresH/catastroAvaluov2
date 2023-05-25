<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 */
class User extends Model
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'fechaCreacion',
        'nombres',
        'apellidos',
        'numeroDocumento',
        'numeroRegistro',
        'tipoUsuario',
        'estado',
        'email'
    ];

    protected $guarded = [];

        
}