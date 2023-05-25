<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\PredioServicio;
use Illuminate\Support\Facades\DB;

class PredioServicioController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $predioservicios = PredioServicio::get();
            $count = 0;
            foreach($predioservicios as $predioservicio){
            	$response["data"][$count]["type"] ="predioservicio"; 
            	$response["data"][$count]["id"]=$predioservicio->idPredioServicio;
            	$response["data"][$count]["attributes"]["idServicio"]=$predioservicio->idServicio;
            	$response["data"][$count]["attributes"]["idPredioDato"] = $predioservicio->idPredioDato;
            	$response["data"][$count]["attributes"]["estado"] = $predioservicio->estado; 
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
            $predioservicio = PredioServicio::find($id);
            $statusCode = 200;
            /*$response = [ "usuario" => [
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'login' => $usuario->login
            ]];*/
            $response = array("data"=>array("type"=>"predioservicio",
            								"id"=>$predioservicio->idPredioServicio,
            								"attributes"=>array(
	            								"idServicio"=>$predioservicio->idServicio,
	            								"idPredioDato" => $predioservicio->idPredioDato,
	                							"estado" => $predioservicio->estado)));
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
    public static function getListPredioServicioByIdUsuario($idUsuario){
        $listPredioServicio = DB::table('predio_servicio as ps')
        ->join('predio_dato as pd', 'pd.idPredioDato', '=', 'ps.idPredioDato')
        ->join('predio as p', 'p.idPredio', '=', 'pd.idPredio')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('ps.*')
        ->where('a.idUsuario', '=', $idUsuario)
        ->get();
        return $listPredioServicio;
    }
    
    public static function getListPredioServicioByIdPredio($idPredio){
        $listPredioServicio = DB::table('predio_servicio as ps')
        ->join('predio_dato as pd', 'pd.idPredioDato', '=', 'ps.idPredioDato')
        ->join('predio as p', 'p.idPredio', '=', 'pd.idPredio')
        ->select('ps.*')
        ->where([
            ['pd.idPredio', '=', $idPredio],
            ['ps.estado','=','AC']
            ])
        ->get();
        return $listPredioServicio;
    }

    //agregado Ruddy

    public static function getListPredioServicioByIdPredioDato($idPredioDato)
    {
        $listPredioServicio = DB::table('predio_servicio as ps')
        ->join('predio_dato as pd', 'pd.idPredioDato', '=', 'ps.idPredioDato')
        ->select('ps.*')
        ->where('pd.idPredioDato', '=', $idPredioDato)
        ->get();
        return $listPredioServicio;
    }

}
