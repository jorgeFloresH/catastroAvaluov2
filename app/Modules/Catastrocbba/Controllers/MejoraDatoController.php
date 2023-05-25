<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Response;
//use App\Modules\Catastrocbba\Models\MejoraDato;

class MejoraDatoController extends Controller
{
    /* public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $mejoradatos = MejoraDato::get();
            $count = 0;
            foreach($mejoradatos as $mejoradato){
            	$response["data"][$count]["type"] ="mejoradato"; 
            	$response["data"][$count]["id"]=$mejoradato->idMejorasDato;
            	$response["data"][$count]["attributes"]["idPredio"]=$mejoradato->idPredio;
            	$response["data"][$count]["attributes"]["idTipoMejora"] = $mejoradato->idTipoMejora;
            	$response["data"][$count]["attributes"]["superficie"] = $mejoradato->superficie;

            	$response["data"][$count]["attributes"]["anioConstruccion"] = $mejoradato->anioConstruccion;
            	$response["data"][$count]["attributes"]["estado"] = $mejoradato->estado; 
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
            $mejoradato = MejoraDato::find($id);
            $statusCode = 200;
        
            $response = array("data"=>array("type"=>"mejoradato","id"=>$mejoradato->idMejorasDato,
            	"attributes"=>array("idPredio"=>$mejoradato->idPredio,"idTipoMejora" => $mejoradato->idMejorasDato,"superficie" => $mejoradato->superficie,"anioConstruccion" => $mejoradato->anioConstruccion,"estado" => $mejoradato->estado)));
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
