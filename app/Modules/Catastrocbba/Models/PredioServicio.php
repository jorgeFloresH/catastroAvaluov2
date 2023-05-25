<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PredioServicio
 */
class PredioServicio extends Model
{
    protected $table = 'predio_servicio';

    protected $primaryKey = 'idPredioServicio';

	public $timestamps = false;

    protected $fillable = [
        'idServicio',
        'idPredioDato',
        'estado'
    ];

    protected $guarded = [];

        
}