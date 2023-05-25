<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\TipoCaracteristica;

class TipoCaracteristicasController extends Controller
{
   public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $tipocaracteristicas = TipoCaracteristica::get();
            $count = 0;
            foreach($tipocaracteristicas as $tipocaracteristica){
            	$response["data"][$count]["type"] ="tipocaracteristica"; 
            	$response["data"][$count]["id"]=$tipocaracteristica->idTipoCaracteristica;
            	$response["data"][$count]["attributes"]["orden"]=$tipocaracteristica->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $tipocaracteristica->descripcion;
            	$response["data"][$count]["attributes"]["estado
            	"] = $tipocaracteristica->estado; 
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
            $tipocaracteristica = TipoCaracteristica::find($id);
            $statusCode = 200;
            /*$response = [ "usuario" => [
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'login' => $usuario->login
            ]];*/
            $response = array("data"=>array("type"=>"tipocaracteristica",
            								"id"=>$tipocaracteristica->idTipoCaracteristica,
            								"attributes"=>array(
	            								"orden"=>$tipocaracteristica->orden,
	            								"descripcion" => $tipocaracteristica->descripcion,
	                							"estado" => $tipocaracteristica->estado)));
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
    public static function getListTipoCaracteristica(){
        return TipoCaracteristica::get();
    }
}
