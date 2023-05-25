<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoeficienteDepreciacion
 */
class CoeficienteDepreciacion extends Model
{
    protected $table = 'coeficiente_depreciacion';

    protected $primaryKey = 'idCoeficienteDepreciacion';

	public $timestamps = false;

    protected $fillable = [
        'orden',
        'descripcion',
        'coeficienteBloque',
        'coeficienteMejora',
        'gestion',
        'estado',
        'anioLimite'
    ];

    protected $guarded = [];

        
}