<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\UbicacionPredio;

class UbicacionPredioController extends Controller
{
  public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $ubicacionpredios = UbicacionPredio::get();
            $count = 0;
            foreach($ubicacionpredios as $ubicacionpredio){
            	$response["data"][$count]["type"] ="ubicacionpredio"; 
            	$response["data"][$count]["id"]=$ubicacionpredio->idUbicacionPredio;
            	$response["data"][$count]["attributes"]["orden"]=$ubicacionpredio->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $ubicacionpredio->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $ubicacionpredio->coeficiente; 
            	$response["data"][$count]["attributes"]["gestion"] = $ubicacionpredio->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $ubicacionpredio->estado; 
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
            $ubicacionpredio = UbicacionPredio::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"ubicacionpredio",
            								"id"=>$ubicacionpredio->idUbicadionPredio,
            								"attributes"=>array(
	            								"orden"=>$ubicacionpredio->orden,
	            								"descripcion" => $ubicacionpredio->descripcion,
	            								"coeficiente" => $ubicacionpredio->coeficiente,
	                							"gestion" => $ubicacionpredio->gestion,
	                							"estado" => $ubicacionpredio->estado)));
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
    }
    
    public static function getListUbicacionPredio(){
        return UbicacionPredio::get();
    }
}
