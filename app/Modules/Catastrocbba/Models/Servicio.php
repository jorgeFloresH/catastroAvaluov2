<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicio
 */
class Servicio extends Model
{
    protected $table = 'servicio';

    protected $primaryKey = 'idServicio';

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