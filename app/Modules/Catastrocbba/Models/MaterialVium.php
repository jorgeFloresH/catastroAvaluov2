<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MaterialVium
 */
class MaterialVium extends Model
{
    protected $table = 'material_via';

    protected $primaryKey = 'idMaterialVia';

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