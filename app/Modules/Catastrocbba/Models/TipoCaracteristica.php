<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoCaracteristica
 */
class TipoCaracteristica extends Model
{
    protected $table = 'tipo_caracteristicas';

    protected $primaryKey = 'idTipoCaracteristica';

	public $timestamps = false;

    protected $fillable = [
        'orden',
        'descripcion',
        'estado'
    ];

    protected $guarded = [];

        
}