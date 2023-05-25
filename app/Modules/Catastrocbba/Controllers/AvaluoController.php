<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\Avaluo;
use Illuminate\Support\Facades\DB;

class AvaluoController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $avaluos = Avaluo::get();
            $count = 0;
            foreach($avaluos as $avaluo){
            	$response["data"][$count]["type"] ="avaluo"; 
            	$response["data"][$count]["id"]=$avaluo->idAvaluo;
            	$response["data"][$count]["attributes"]["numerohabilitado"]=$avaluo->numeroHabilitado;
            	$response["data"][$count]["attributes"]["estadoavaluo"] = $avaluo->estadoAvaluo;
            	$response["data"][$count]["attributes"]["fechaavaluo"] = $avaluo->fechaAvaluo; 
            	$response["data"][$count]["attributes"]["estadoimpresion"]=$avaluo->estadoImpresion;
            	$response["data"][$count]["attributes"]["fecharegistro"] = $avaluo->fechaRegistro;
            	$response["data"][$count]["attributes"]["fechaimpresion"] = $avaluo->fechaImpresion; 
            	$response["data"][$count]["attributes"]["estado"]=$avaluo->estado;
            	$response["data"][$count]["attributes"]["superficiepredio"] = $avaluo->superficiePredio;
            	$response["data"][$count]["attributes"]["superficiebloques"] = $avaluo->superficieBloques; 
            	$response["data"][$count]["attributes"]["superficiemejoras"]=$avaluo->superficieMejoras;
            	$response["data"][$count]["attributes"]["valorterreno"] = $avaluo->valorTerreno;
            	$response["data"][$count]["attributes"]["valorbloques"] = $avaluo->valorBloques; 
            	$response["data"][$count]["attributes"]["valormejoras"] = $avaluo->valorMejoras; 
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
            $avaluo = Avaluo::find($id);
            $statusCode = 200;
            /*$response = [ "usuario" => [
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'login' => $usuario->login
            ]];*/
            $response = array("data"=>array("type"=>"avaluo",
            								"id"=>$avaluo->idAvaluo,
            								"attributes"=>array(
	            								"numerohabilitado"=>$avaluo->numeroHabilitado,
	            								"estadoavaluo" => $avaluo->estadoAvaluo,
	            								"fechaavaluo"=>$avaluo->fechaAvaluo,
	            								"estadoimpresion" => $avaluo->estadoImpresion,
	            								"fecharegistro"=>$avaluo->fechaRegistro,
	            								"fechaimpresion" => $avaluo->fechaImpresion,
	            								"estado"=>$avaluo->estado,
	            								"superficiepredio" => $avaluo->superficiePredio,
	            								"superficiebloques"=>$avaluo->superficieBloques,
	            								"superficiemejoras" => $avaluo->superficieMejoras,
	            								"valorterreno"=>$avaluo->valorTerreno,
	            								"valorbloques" => $avaluo->valorBloques,
	                							"valormejoras" => $avaluo->valorMejoras)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }
    public function store(Request $request){
        try{
            $input = $request->all();
            $id = DB::table('avaluo')->insertGetId(
                $input
            );
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","last_insert_id"=>$id), 200);
    }
    
    public static function getListAvaluosByIdUsuario($idUsuario){
        return Avaluo::where([['idUsuario','=',$idUsuario],['estado','=','AC']])->get();
    }

    //agregado Ruddy
    public static function getListAvaluosByIdAvaluo($idAvaluo)
    {
        return Avaluo::where([['idAvaluo','=',$idAvaluo],['estado','=','AC']])->get();
    }
    
    public static function getAvaluoActualizadoByPrintByIdPredio($idPredio){
        
        $avaluo = DB::table('predio as p')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('a.*',DB::raw("MAX(a.numeroFormulario) AS maximo"))
        ->first();
        

        $avaluoPredio = DB::table('predio as p')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('a.*')
        ->where('p.idPredio','=',$idPredio)
        ->first();
        
        if (empty($avaluo)) {
            Avaluo::where('idAvaluo', $avaluoPredio->idAvaluo)
            ->update(['numeroFormulario' => 1,'fechaImpresion'=>date("Y-m-d H:i:s")]);
        }
        else
        {
            Avaluo::where('idAvaluo', $avaluoPredio->idAvaluo)
            ->update(['numeroFormulario' => ($avaluo->maximo+1),'fechaImpresion'=>date("Y-m-d H:i:s")]);
        }
        
        
        $nuevoAvaluo=Avaluo::find($avaluoPredio->idAvaluo);
        
        return $nuevoAvaluo;
    }

    public static function getAvaluoByPrintByIdPredio($idPredio)
    {
        $avaluoPredio = DB::table('predio as p')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('a.*')
        ->where('p.idPredio','=',$idPredio)
        ->first();
        
        $nuevoAvaluo=Avaluo::find($avaluoPredio->idAvaluo);
        
        return $nuevoAvaluo;
    }

    //agregado Ruddy
    public static function getEstadoAvaluoByIdPredio($idPredio)
    {
        $avaluoPredio = DB::table('predio as p')
        ->join('avaluo as a','a.idAvaluo','=','p.idAvaluo')
        ->select('a.*')
        ->where('p.idPredio','=',$idPredio)
        ->first();
        return Response::json(array('estadoAvaluo'=>$avaluoPredio->estadoAvaluo));
    }

    public static function getNroFormularioByIdPredio($idPredio)
    {
        $avaluoPredio = DB::table('predio as p')
        ->join('avaluo as a','a.idAvaluo','=','p.idAvaluo')
        ->select('a.*')
        ->where('p.idPredio','=',$idPredio)
        ->first();
        return Response::json(array('nroFormulario'=>$avaluoPredio->numeroFormulario));
    }
}
