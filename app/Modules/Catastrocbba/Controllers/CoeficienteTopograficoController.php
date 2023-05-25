<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\CoeficienteTopografico;

class CoeficienteTopograficoController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $coeficientesTopograficos = CoeficienteTopografico::get();
            $count = 0;
            foreach($coeficientesTopograficos as $coeficienteTopografico){
            	$response["data"][$count]["type"] ="coeficientetopografico"; 
            	$response["data"][$count]["id"]=$coeficienteTopografico->idCoeficienteTopografico;
            	$response["data"][$count]["attributes"]["orden"]=$coeficienteTopografico->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $coeficienteTopografico->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $coeficienteTopografico->coeficiente; 
            	$response["data"][$count]["attributes"]["gestion"] = $coeficienteTopografico->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $coeficienteTopografico->estado; 
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
            $coeficientesTopograficos = CoeficienteTopografico::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"coeficientesTopograficos",
                                            "id"=>$coeficientesTopograficos->idCoeficienteTopografico,
                                            "attributes"=>array(
                                                "orden" => $coeficientesTopograficos->orden,
                                                "descripcion" => $coeficientesTopograficos->descripcion,
                                                "coeficiente" => $coeficientesTopograficos->coeficiente,
                                                "gestion" => $coeficientesTopograficos->gestion,
                                                "estado" => $coeficientesTopograficos->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }

	public static function getListCoeficientesTopografico(){
	    return CoeficienteTopografico::get();
	}
}
