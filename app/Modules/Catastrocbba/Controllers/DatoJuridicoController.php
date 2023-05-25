<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Response;
//use App\Modules\Catastrocbba\Models\DatosJuridico;

class DatosJuridicoController extends Controller
{
     /*public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $datosJuridicos = DatosJuridico::get();
            $count = 0;
            foreach($datosJuridicos as $datosJuridico){
            	$response["data"][$count]["type"] ="datosJuridico"; 
            	$response["data"][$count]["id"]=$datosJuridico->idDatoJuridico;
            	$response["data"][$count]["attributes"]["idpredio"]=$datosJuridico->idPredio;
            	$response["data"][$count]["attributes"]["matricula"] = $datosJuridico->matricula;
            	$response["data"][$count]["attributes"]["asiento"] = $datosJuridico->asiento; 
            	$response["data"][$count]["attributes"]["fojas"] = $datosJuridico->fojas;
            	$response["data"][$count]["attributes"]["partida"] = $datosJuridico->partida;
            	$response["data"][$count]["attributes"]["fechatestimonio"]=$datosJuridico->fechaTestimonio;
            	$response["data"][$count]["attributes"]["numerotestimonio"] = $datosJuridico->numeroTestimonio;
            	$response["data"][$count]["attributes"]["nombrenotario"] = $datosJuridico->nombreNotario; 
            	$response["data"][$count]["attributes"]["fecharegistroddrr"] = $datosJuridico->fechaRegistroDDRR;
            	$response["data"][$count]["attributes"]["estado"] = $datosJuridico->estado; 
            	$count = $count + 1;               
            }    
        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
	}*/
}
