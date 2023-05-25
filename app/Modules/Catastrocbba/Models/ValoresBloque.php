<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ValoresBloque
 */
class ValoresBloque extends Model
{
    protected $table = 'valores_bloque';

    protected $primaryKey = 'idValorBloque';

	public $timestamps = false;

    protected $fillable = [
        'idBloqueDato',
        'idCaracteristicaBloque',
        'orden',
        'porcentaje',
        'puntaje',
        'estado'
    ];

    protected $guarded = [];

        
}