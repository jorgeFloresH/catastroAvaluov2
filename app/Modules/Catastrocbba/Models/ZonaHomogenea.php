<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ZonaHomogenea
 */
class ZonaHomogenea extends Model
{
    protected $table = 'zona_homogenea';

    protected $primaryKey = 'idZonaHomogenea';

	public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'codigoZona',
        'valorCatastralM2',
        'valorComercialM2',
        'gestion',
        'estado'
    ];

    protected $guarded = [];

        
}