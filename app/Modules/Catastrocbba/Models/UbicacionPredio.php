<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UbicacionPredio
 */
class UbicacionPredio extends Model
{
    protected $table = 'ubicacion_predio';

    protected $primaryKey = 'idUbicacionPredio';

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