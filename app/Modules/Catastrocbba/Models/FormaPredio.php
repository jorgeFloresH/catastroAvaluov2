<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FormaPredio
 */
class FormaPredio extends Model
{
    protected $table = 'forma_predio';

    protected $primaryKey = 'idFormaPredio';

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