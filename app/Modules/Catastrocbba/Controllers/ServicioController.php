<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\Servicio;
use App\Modules\Catastrocbba\Models\PredioDato;
use App\Modules\Catastrocbba\Models\PredioServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServicioController extends Controller
{
     public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $servicios = Servicio::get();
            $count = 0;
            foreach($servicios as $servicio){
            	$response["data"][$count]["type"] ="servicio"; 
            	$response["data"][$count]["id"]=$servicio->idServicio;
            	$response["data"][$count]["attributes"]["orden"]=$servicio->orden;
            	$response["data"][$count]["attributes"]["descripcion"] = $servicio->descripcion;
            	$response["data"][$count]["attributes"]["coeficiente"] = $servicio->coeficiente; 
            	$response["data"][$count]["attributes"]["gestion"] = $servicio->gestion;
            	$response["data"][$count]["attributes"]["estado"] = $servicio->estado; 
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
            $servicio = Servicio::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"servicio",
            								"id"=>$servicio->idServicio,
            								"attributes"=>array(
	            								"orden"=>$servicio->orden,
	            								"descripcion" => $servicio->descripcion,
	            								"coeficiente" => $servicio->coeficiente,
	                							"gestion" => $servicio->gestion,
	                							"estado" => $servicio->estado)));
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
        //return 'VAlor;'.$request->input('type');
		try{
            $input = $request->all();
            $id = DB::table('predio_servicio')->insertGetId($input);
       }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","last_insert_id"=>$id), 200);
    }
	
	public function update(Request $request) {
        //return 'VAlor;'.$request->input('type');
		try{
            $input = $request->all();
            
            PredioServicio::where('idPredioServicio', $input["idPredioServicio"])->update($input);
            
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
	
    public static function getListServicio(){
        return Servicio::get();
    }
    public function listaServicios(Request $request) {
        return 'VAlor;'.$request->input('type');
    }
    public function getListServiciosByIdPredio($idPredio){
        $listaServicios=array();
        $predioDato=PredioDato::where('idPredio','=',$idPredio)->first();
        if(isset($predioDato["idPredioDato"]) && strlen($predioDato["idPredioDato"])>0){
            $idPredioDato=$predioDato["idPredioDato"];
            $listaServicios = DB::table('servicio as s')
            ->join('predio_servicio as ps', 'ps.idServicio', '=', 's.idServicio')
            ->select('s.*')
            ->where([
                ['ps.idPredioDato', '=', $idPredioDato],
                ['ps.estado','like','AC']
                ])
            ->get();
        }
        return $listaServicios;
        
    }

    public static function actualizarPredioServicioForDeleteDuplicates($idPredio){
        $predioDato=PredioDato::where('idPredio','=',$idPredio)->first();
        $list = [];
        if(isset($predioDato))
        {
            $list = PredioServicio::where([
                ['idPredioDato','=', $predioDato->idPredioDato],
                ['estado','=','AC']
                ])->get();
            $listServiciosTemp = [];
            foreach($list as $ps)
            {
                $existThisServ = false;
                foreach($listServiciosTemp as $ps2)
                {
                    if($ps2->idServicio == $ps->idServicio)
                    {
                        $existThisServ = true;
                    }
                }

                if($existThisServ == false)
                {
                    array_push($listServiciosTemp,$ps);
                }
                else
                {
                    $psup = PredioServicio::find($ps->idPredioServicio);
                    if(isset($psup))
                    {
                        $psup->estado = 'EL';
                        $psup->save();
                    }
                }
            }
        }
        return $list;
    }
    
}
