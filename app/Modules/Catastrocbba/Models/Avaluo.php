<?php

namespace App\Modules\Catastrocbba\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Avaluo
 */
class Avaluo extends Model
{
    protected $table = 'avaluo';

    protected $primaryKey = 'idAvaluo';

	public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'numeroHabilitado',
        'estadoAvaluo',
        'fechaAvaluo',
        'estadoImpresion',
        'fechaRegistro',
        'fechaImpresion',
        'estado',
        'superficiePredio',
        'superficieBloques',
        'superficieMejoras',
        'valorTerreno',
        'valorBloques',
        'valorMejoras',
        'numeroFormulario'
    ];

    protected $guarded = [];

        
}