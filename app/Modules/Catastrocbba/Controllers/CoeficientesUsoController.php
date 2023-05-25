<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\CoeficienteUso;

class CoeficientesUsoController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $coeficientesUsos = CoeficienteUso::get();
            $count = 0;
            foreach($coeficientesUsos as $CoeficienteUso){
            	$response["data"][$count]["type"] ="CoeficienteUso"; 
            	$response["data"][$count]["id"]=$CoeficienteUso->idCoeficienteUso;
            	$response["data"][$count]["attributes"]["orden"]=$CoeficienteUso->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $CoeficienteUso->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $CoeficienteUso->coeficiente; 
            	$response["data"][$count]["attributes"]["gestion"] = $CoeficienteUso->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $CoeficienteUso->estado; 
            	$count = $count + 1;               
            }    
        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
	}
	public static function getListCoefecienteUso(){
	    return CoeficienteUso::get();
	}
}
