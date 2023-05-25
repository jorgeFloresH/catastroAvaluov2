<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipologiasMejora
 */
class TipologiasMejora extends Model
{
    protected $table = 'tipologias_mejora';

    protected $primaryKey = 'idTipologiasMejora';

	public $timestamps = false;

    protected $fillable = [
        'idTipoMejora',
        'puntaje',
        'valorM2',
        'gestion',
        'estado'
    ];

    protected $guarded = [];

        
}