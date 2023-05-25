<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\TipoMejora;

class TipoMejoraController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $tipomejoras = TipoMejora::orderBy('orden','asc')->get();
            $count = 0;
            foreach($tipomejoras as $tipomejora){
            	$response["data"][$count]["type"] ="tipomejora"; 
            	$response["data"][$count]["id"]=$tipomejora->idTipoMejora;
            	$response["data"][$count]["attributes"]["orden"]=$tipomejora->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $tipomejora->descripcion;
            	$response["data"][$count]["attributes"]["estado
            	"] = $tipomejora->estado; 
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
            $tipomejora = TipoMejora::find($id);
            $statusCode = 200;
            /*$response = [ "usuario" => [
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'login' => $usuario->login
            ]];*/
            $response = array("data"=>array("type"=>"TipoMejora",
            								"id"=>$tipomejora->idTipoMejora,
            								"attributes"=>array(
	            								"orden"=>$tipomejoraa->orden,
	            								"descripcion" => $tipomejora->descripcion,
	                							"estado" => $tipomejora->estado)));
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
    public static function getListTipoMejora(){
        return TipoMejora::get();
    }
}
