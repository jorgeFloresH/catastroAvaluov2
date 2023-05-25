<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipologiasConstructiva
 */
class TipologiasConstructiva extends Model
{
    protected $table = 'tipologias_constructiva';

    protected $primaryKey = 'idTipologiasConstructiva';

	public $timestamps = false;

    protected $fillable = [
        'orden',
        'descripcion',
        'valorM2',
        'valorM2PH',
        'puntaje',
        'gestion',
        'estado'
    ];

    protected $guarded = [];

        
}