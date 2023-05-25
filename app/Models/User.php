<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Class User
 */
class User extends Authenticatable
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'sistema',
        'id_sistema',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    protected $guarded = [];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
        
}