<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\MaterialVium;

class MaterialViumController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $materialviums = MaterialVium::get();
            $count = 0;
            foreach($materialviums as $materialvium){
            	$response["data"][$count]["type"] ="materialvia"; 
            	$response["data"][$count]["id"]=$materialvium->idMaterialVia;
            	$response["data"][$count]["attributes"]["orden"]=$materialvium->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $materialvium->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $materialvium->coeficiente; 
            	$response["data"][$count]["attributes"]["gestion"] = $materialvium->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $materialvium->estado; 
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
            $materialvium = MaterialVium::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"materialvia",
            								"id"=>$materialvium->idMaterialVia,
            								"attributes"=>array(
	            								"orden"=>$materialvium->orden,
	            								"descripcion" => $materialvium->descripcion,
	                							"coeficiente" => $materialvium->coeficiente,"gestion"=>$materialvium->gestion,
	            								"estado" => $materialvium->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }
    public static function getListMaterialVia(){
        return MaterialVium::get();
    }

}
