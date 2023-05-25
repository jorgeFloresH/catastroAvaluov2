<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DatosPropietario
 */
class DatosPropietario extends Model
{
    protected $table = 'datos_propietario';

    protected $primaryKey = 'idDatosPropietario';

	public $timestamps = false;

    protected $fillable = [
        'idPredio',
        'apellidoUno',
        'apellidoDos',
        'nombres',
        'numeroDocumento',
        'idEmitidoEn',
        'numeroNIT',
        'porcentaje',
        'matricula',
        'asiento',
        'fojas',
        'partida',
        'fechaTestimonio',
        'numeroTestimonio',
        'fechaRegistroDDRR',
        'estado',
        'denominacion',
        'notario'
    ];

    protected $guarded = [];

        
}