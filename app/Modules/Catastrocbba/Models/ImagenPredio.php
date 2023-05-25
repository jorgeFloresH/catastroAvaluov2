<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ImagenPredio
 */
class ImagenPredio extends Model
{
    protected $table = 'imagen_predio';

    protected $primaryKey = 'idImagenPredio';

	public $timestamps = false;

    protected $fillable = [
        'idPredio',
        'imagen',
        'idRelacion',
        'tipoRelacion',
        'estado'
    ];

    protected $guarded = [];

        
}