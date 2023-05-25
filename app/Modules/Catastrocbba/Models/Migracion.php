<?php

namespace App\Modules\catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

class Migracion extends Model
{
    //

    protected $table = 'migracion';

    protected $primaryKey = 'idMigracion';

	public $timestamps = false;

    protected $fillable = [
        'fechaMigracion',
        'idUsuario',
        'idAvaluo',
        'ipUsuario',
        'datosUsuario'
    ];

    protected $guarded = [];
}
