<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\CoeficienteDepreciacion;

class CoeficienteDepreciacionController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $coeficienteDepreciaciones = CoeficienteDepreciacion::get();
            $count = 0;
            foreach($coeficienteDepreciaciones as $coeficienteDepreciacion){
            	$response["data"][$count]["type"] ="coeficienteDepreciacion"; 
            	$response["data"][$count]["id"]=$coeficienteDepreciacion->idCoeficienteDepreciacion;
            	$response["data"][$count]["attributes"]["orden"]=$coeficienteDepreciacion->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $coeficienteDepreciacion->descripcion;
            	$response["data"][$count]["attributes"]["coeficienteBloque"] = $coeficienteDepreciacion->coeficienteBloque; 
            	$response["data"][$count]["attributes"]["coeficienteMejora"]=$coeficienteDepreciacion->coeficienteMejora;
            	$response["data"][$count]["attributes"]["gestion"] = $coeficienteDepreciacion->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $coeficienteDepreciacion->estado; 
            	$count = $count + 1;               
            }    
        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
    }

    public function show($id) {
        try{
            $coeficienteDepreciaciones = CoeficienteDepreciacion::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"coeficienteDepreciaciones",
                                            "id"=>$coeficienteDepreciaciones->idCoeficienteDepreciacion,
                                            "attributes"=>array(
                                                "orden" => $coeficienteDepreciaciones->orden,
                                                "descripcion" => $coeficienteDepreciaciones->descripcion,
                                                "coeficienteBloque" => $coeficienteDepreciaciones->coeficienteBloque,
                                                "coeficienteMejora" => $coeficienteDepreciaciones->coeficienteMejora,
                                                "gestion" => $coeficienteDepreciaciones->gestion,
                                                "estado" => $coeficienteDepreciaciones->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }


    public static function getListCoefecienteDepreciacion(){
        return CoeficienteDepreciacion::get();
    }
    
}
