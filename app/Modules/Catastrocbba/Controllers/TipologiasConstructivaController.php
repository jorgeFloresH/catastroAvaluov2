<?php
namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\TipologiasConstructiva;

class TipologiasConstructivaController extends Controller
{
    public static function getListTipologiaConstructiva(){
        return TipologiasConstructiva::get();
    }
    public static function getTipologiaByPuntaje($puntaje){
        return TipologiasConstructiva::where('puntaje','>=',$puntaje)->first();
    }
}

?>