<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoMejora
 */
class TipoMejora extends Model
{
    protected $table = 'tipo_mejora';

    protected $primaryKey = 'idTipoMejora';

	public $timestamps = false;

    protected $fillable = [
        'orden',
        'descripcion',
        'estado'
    ];

    protected $guarded = [];

        
}