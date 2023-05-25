<?php
namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\TipologiasMejora;

class TipologiasMejoraController extends Controller
{
    public static function getListTipologiaMejora(){
        return TipologiasMejora::get();
    }
}

?>