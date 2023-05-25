<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Predio
 */
class Predio extends Model
{
    protected $table = 'predio';

    protected $primaryKey = 'idPredio';

	public $timestamps = false;

    protected $fillable = [
        'codigoSubDistrito',
        'codigoManzana',
        'codigoPredio',
        'codigoUso',
        'codigoBloque',
        'codigoPlanta',
        'codigoUnidad',
        'numeroInmueble',
        'direccion',
        'numeroPuerta',
        'nombreEdificio',
        'bloque',
        'planta',
        'departamento',
        'latitud',
        'longitud',
        'codigoCatastral',
        'geocodigo',
        'idAvaluo',
        'estado',
        'pmc'
    ];

    protected $guarded = [];

        
}