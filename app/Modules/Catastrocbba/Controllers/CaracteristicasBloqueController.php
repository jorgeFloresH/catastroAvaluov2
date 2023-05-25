<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\CaracteristicasBloque;

class CaracteristicasBloqueController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $caracteristicasBloques = CaracteristicasBloque::get();
            $count = 0;
            foreach($caracteristicasBloques as $caracteristicasBloque){
            	$response["data"][$count]["type"] ="caracteristicasBloque"; 
            	$response["data"][$count]["id"]=$caracteristicasBloque->idCaracteristicaBloque;
            	$response["data"][$count]["attributes"]["idtipocaracteristica"]=$caracteristicasBloque->idTipoCaracteristica;
            	$response["data"][$count]["attributes"]["orden"] = $caracteristicasBloque->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $caracteristicasBloque->descripcion; 
            	$response["data"][$count]["attributes"]["puntaje"]=$caracteristicasBloque->puntaje;
            	$response["data"][$count]["attributes"]["estado"] = $caracteristicasBloque->estado;
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
            $caracteristicasBloque = CaracteristicasBloque::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"caracteristicasBloque",
            								"id"=>$caracteristicasBloque->idCaracteristicaBloque,
            								"attributes"=>array(
	            								"idtipocaracteristica"=>$caracteristicasBloque->idTipoCaracteristica,
	            								"orden" => $caracteristicasBloque->orden,
	                							"descripcion" => $caracteristicasBloque->descripcion,
	                							"puntaje" => $caracteristicasBloque->puntaje,
	                							"estado" => $caracteristicasBloque->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }

    public function caracteristicasbloqueportipo($id = null) {
        try{
            $statusCode = 200;
            $listaCarasteristicaBloque = CaracteristicasBloque::where('idTipoCaracteristica', '=',$id) ->get();
            $listaCarasteristicaBloqueArray = array();
            foreach ($listaCarasteristicaBloque as $caracteristica) {
                $listaCarasteristicaBloqueArray[$caracteristica->idCaracteristicaBloque] = $caracteristica;
            }

        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($listaCarasteristicaBloqueArray, $statusCode);
        }        
    }


    public static function getListCaracteristicasBloque(){
        return CaracteristicasBloque::get();
    }
    public static function getListCaracteristicasBloqueByIdTipoCaracteristica($idTipoCaracteristica){
        return CaracteristicasBloque::where('idTipoCaracteristica', '=',$idTipoCaracteristica) ->get();
    }

}
