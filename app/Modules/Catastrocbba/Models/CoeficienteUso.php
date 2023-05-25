<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoeficienteUso
 */
class CoeficienteUso extends Model
{
    protected $table = 'coeficiente_uso';

    protected $primaryKey = 'idCoeficienteUso';

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