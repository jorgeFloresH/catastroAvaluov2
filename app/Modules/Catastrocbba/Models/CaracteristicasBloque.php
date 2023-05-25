<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CaracteristicasBloque
 */
class CaracteristicasBloque extends Model
{
    protected $table = 'caracteristicas_bloque';

    protected $primaryKey = 'idCaracteristicaBloque';

	public $timestamps = false;

    protected $fillable = [
        'idTipoCaracteristica',
        'orden',
        'descripcion',
        'puntaje',
        'estado'
    ];

    protected $guarded = [];

        
}