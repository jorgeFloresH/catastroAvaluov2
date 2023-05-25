<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\FormaPredio;

class FormaPredioController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $formapredios = FormaPredio::get();
            $count = 0;
            foreach($formapredios as $formapredio){
            	$response["data"][$count]["type"] ="formapredio"; 
            	$response["data"][$count]["id"]=$formapredio->idFormaPredio;
            	$response["data"][$count]["attributes"]["orden"]=$formapredio->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $formapredio->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $formapredio->coeficiente; 
            	$response["data"][$count]["attributes"]["gestion"] = $formapredio->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $formapredio->estado; 
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
            $formapredios = FormaPredio::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"formapredios",
                                            "id"=>$formapredios->idFormaPredio,
                                            "attributes"=>array(
                                                "orden" => $formapredios->orden,
                                                "descripcion" => $formapredios->descripcion,
                                                "coeficiente" => $formapredios->coeficiente,
                                                "gestion" => $formapredios->gestion,
                                                "estado" => $formapredios->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }
    
	public static function getListFormaPredio(){
	    return FormaPredio::get();
	}
	
}
