<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BloquesDato
 */
class BloquesDato extends Model
{
    protected $table = 'bloques_dato';

    protected $primaryKey = 'idBloqueDato';

	public $timestamps = false;

    protected $fillable = [
        'idPredio',
        'numerobloque',
        'superficieBloque',
        'anioConstruccion',
        'cantidadPisos',
        'idCoeficienteUso',
        'idCoeficienteDepreciacion',
        'observaciones',
        'tipoBloque',
        'estado',
        'gestion',
        'idTipoMejora'
    ];

    protected $guarded = [];

        
}