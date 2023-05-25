<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoeficienteTopografico
 */
class CoeficienteTopografico extends Model
{
    protected $table = 'coeficiente_topografico';

    protected $primaryKey = 'idCoeficienteTopografico';

	public $timestamps = false;

    protected $fillable = [
        'orden',
        'descripcion',
        'coeficiente',
        'gestion',
        'estado'
    ];

    protected $guarded = [];

        
}