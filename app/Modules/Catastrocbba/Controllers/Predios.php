<?php

namespace App\Modules\Catastrocbba\Controllers;

use Response;
use Illuminate\Http\Request;
use App\Modules\Catastrocbba\Models\Predio;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Predios extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $predios = Predio::get();
            $count = 0;
            foreach($predios as $predio){
            	$response["data"][$count]["type"] ="predio"; 
            	$response["data"][$count]["id"]=$predio->idPredio;
            	$response["data"][$count]["attributes"]["codigoSubdistrito"]=$predio->codigoSubDistrito;
            	$response["data"][$count]["attributes"]["codigomanzana"] = $predio->codigoManzana;
            	$response["data"][$count]["attributes"]["codigopredio"] = $predio->codigoPredio; 
                $response["data"][$count]["attributes"]["codigouso"]=$predio->codigoUso;
                $response["data"][$count]["attributes"]["codigobloque"] = $predio->codigoBloque;
                $response["data"][$count]["attributes"]["codigoplanta"] = $predio->codigoPlanta; 
                $response["data"][$count]["attributes"]["codigounidad"]=$predio->codigoUnidad;
                $response["data"][$count]["attributes"]["numeroinmueble"] = $predio->numeroInmueble;
                $response["data"][$count]["attributes"]["direccion"] = $predio->direccion; 
                $response["data"][$count]["attributes"]["numeropuerta"]=$predio->numeroPuerta;
                $response["data"][$count]["attributes"]["nombreedificio"] = $predio->nombreEdificio;
                $response["data"][$count]["attributes"]["piso"] = $predio->piso; 
                $response["data"][$count]["attributes"]["planta"]=$predio->planta;
                $response["data"][$count]["attributes"]["departamento"] = $predio->departamento;
                $response["data"][$count]["attributes"]["latitud"] = $predio->latitud; 
                $response["data"][$count]["attributes"]["longitud"]=$predio->longitud;
                $response["data"][$count]["attributes"]["codigoCatastral"] = $predio->codigoCatastral;
                $response["data"][$count]["attributes"]["goecodigo"] = $predio->goecodigo; 
                $response["data"][$count]["attributes"]["idavaluo"]=$predio->idAvaluo;
                $response["data"][$count]["attributes"]["estado"] = $predio->estado;
                 
            	$count = $count + 1;               
            }    
        }catch (Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
        //return Usuario::get();
    }

    public function show($id) {
        try{
            $predio = Predio::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"predio",
            								"id"=>$predio->idPredio,
            								"attributes"=>array(
	            								"codigoSubdistrito"=>$predio->codigoSubDistrito,
	            								"codigomanzana" => $predio->codigoManzana,
	                							"codigopredio" => $predio->codigoPredio,
                                                "codigouso"=>$predio->codigoUso,
                                                "codigobloque" => $predio->codigoBloque,
                                                "codigoplanta" => $predio->codigoPlanta,
                                                "codigounidad"=>$predio->codigoUnidad,
                                                "numeroinmueble" => $predio->numeroInmueble,
                                                "direccion" => $predio->direccion,
                                                "numeropuerta"=>$predio->numeroPuerta,
                                                "piso" => $predio->piso,
                                                "planta" => $predio->planta,
                                                "departamento"=>$predio->departamento,
                                                "latitud" => $predio->latitud,
                                                "longitud" => $predio->longitud,
                                                "codigocatastral"=>$predio->codigoCatastral,
                                                "nombreedificio" => $predio->nombreEdificio,
                                                "goecodigo" => $predio->goecodigo,
                                                "idAvaluo"=>$predio->idAvaluo,
                                                "estado" => $predio->estado,
                                                )));
        }catch(Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }
}
