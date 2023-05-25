<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Response;
//use App\Modules\Catastrocbba\Models\NivelPredio;

class NivelPredioController extends Controller
{
    /*public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $nivelpredio = NivelPredio::get();
            $count = 0;
            foreach($nivelpredios as $nivelpredio){
            	$response["data"][$count]["type"] ="nivelpredio"; 
            	$response["data"][$count]["id"]=$nivelpredio->idNivelPredio;
            	$response["data"][$count]["attributes"]["orden"]=$nivelpredio->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $nivelpredio->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $nivelpredio->coeficiente;
            	$response["data"][$count]["attributes"]["gestion"] = $nivelpredio->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $nivelpredio->estado; 
            	$count = $count + 1;               
            }    
        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
        //return Usuario::get();
    }

    public function show($id) {
        try{
            $nivelpredio = NivelPredio::find($id);
            $statusCode = 200;
           
            $response = array("data"=>array("type"=>"nivelpredio",
            								"id"=>$nivelpredio->idNivelPredio,
            								"attributes"=>array(
	            								"orden"=>$nivelpredio->orden,
	            								"descripcion" => $nivelpredio->descripcion,
	                							"coeficiente" => $nivelpredio->coeficiente, 
	            								"gestion" => $nivelpredio->gestion,
	                							"estado" => $nivelpredio->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }

    public function store(Request $request) {
        return 'VAlor;'.$request->input('type');
    }*/
}
