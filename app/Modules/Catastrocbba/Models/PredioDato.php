<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PredioDato
 */
class PredioDato extends Model
{
    protected $table = 'predio_dato';

    protected $primaryKey = 'idPredioDato';

	public $timestamps = false;

    protected $fillable = [
        'idPredio',
        'idCoeficienteTopografico',
        'idZonaHomogenea',
        'idFormaPredio',
        'idUbicacionPredio',
        'idMaterialVia',
        'frentePredio',
        'fondoPredio',
        'superficieAprobada',
        'estado',
        'observaciones'
    ];

    protected $guarded = [];

        
}