<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\ZonaHomogenea;

class ZonaHomogeneaController extends Controller
{
   public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $zonahomogeneas = ZonaHomogenea::get();
            $count = 0;
            foreach($zonahomogeneas as $zonahomogenea){
            	$response["data"][$count]["type"] ="zonahomogenea"; 
            	$response["data"][$count]["id"]=$zonahomogenea->idZonaHomogenea;
            	$response["data"][$count]["attributes"]["descripcion"] = $zonahomogenea->descripcion;
            	$response["data"][$count]["attributes"]["codigoZona"]=$zonahomogenea->codigoZona;
            	$response["data"][$count]["attributes"]["valorCatastralM2"] =$zonahomogenea->valorCatastralM2; 
            	$response["data"][$count]["attributes"]["valorCatastralM2PH"] =$zonahomogenea->valorCatastralM2PH; 
            	$response["data"][$count]["attributes"]["gestion"] = $zonahomogenea->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $zonahomogenea->estado; 
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
            $zonahomogenea = ZonaHomogenea::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"zonahomogenea",
            								"id"=>$zonahomogenea->idZonaHomogenea,
            								"attributes"=>array(
	            								"descripcion" => $zonahomogenea->descripcion,
	            								"codigoZona"=>$zonahomogenea->codigoZona,
	            								"valorCatastralM2" => $zonahomogenea->valorCatastralM2,
	            								"valorCatastralM2PH" => $zonahomogenea->valorCatastralM2PH,
	                							"gestion" => $zonahomogenea->gestion,
	                							"estado" => $zonahomogenea->estado)));
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
    public static function getListZonaHomogenea(){
        return ZonaHomogenea::get();
    }
    
}
