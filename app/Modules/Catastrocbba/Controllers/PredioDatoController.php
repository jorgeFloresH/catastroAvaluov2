<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\PredioDato;
use App\Modules\Catastrocbba\Models\PredioServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PredioDatoController extends Controller
{
    public function store(Request $request){
        try{
            $input = $request->all();
            $id = DB::table('predio_dato')->insertGetId($input);
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","last_insert_id"=>$id), 200);
    }
    public function update(Request $request){
    
        try{
            $input = $request->all();
            PredioDato::where('idPredioDato', $input["idPredioDato"])->update($input);
    
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
    
    public function storePredioDatoAndListIdService(Request $request){
        try{
            
            $predioDatoJson=$request->input("predioDato");
            $listaIdServiciosJson=$request->input("listaIdServicios");
            $idPredioDato = DB::table('predio_dato')->insertGetId($predioDatoJson);
            
            $listaPredioServicio=array();
            if($idPredioDato!=null){
                $arrayIdPredioServicio=$listaIdServiciosJson;
                
                foreach ($arrayIdPredioServicio as $idServicio){
                    $predioServicio=new PredioServicio();
                    $predioServicio->idServicio=$idServicio;
                    $predioServicio->idPredioDato=$idPredioDato;
                    $predioServicio->estado="AC";
                    $predioServicio->save();
                    $listaPredioServicio[]=$predioServicio;
                }
                
            }
            
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"idPredioDato"=>null,"listaPredioServicio"=>$listaPredioServicio), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","idPredioDato"=>$idPredioDato,"listaPredioServicio"=>$listaPredioServicio), 200);
    }
    public function updatePredioDatoAndListIdService(Request $request){
        try{
            $predioDatoJson=$request->input("predioDato");
            $listaIdServiciosJson=$request->input("listaIdServicios");
            
            PredioDato::where('idPredioDato', $predioDatoJson["idPredioDato"])->update($predioDatoJson);
            PredioServicio::where('idPredioDato','=' ,$predioDatoJson["idPredioDato"])->delete();
            
            $listaPredioServicio=array();
            if($predioDatoJson["idPredioDato"]!=null){
                $arrayIdPredioServicio=$listaIdServiciosJson;
            
                foreach ($arrayIdPredioServicio as $idServicio){
                    $predioServicio=new PredioServicio();
                    $predioServicio->idServicio=$idServicio;
                    $predioServicio->idPredioDato=$predioDatoJson["idPredioDato"];
                    $predioServicio->estado="AC";
                    $predioServicio->save();
                    $listaPredioServicio[]=$predioServicio;
                }
            }
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"listaPredioServicio"=>$listaPredioServicio), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","listaPredioServicio"=>$listaPredioServicio), 200);
    }
    
    
    public static function getListPredioDatoByIdUsuario($idUsuario){
        $listaPredioDato = DB::table('predio_dato as pd')
        ->join('predio as p', 'p.idPredio', '=', 'pd.idPredio')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('pd.*')
        ->where('a.idUsuario', '=', $idUsuario)
        ->get();
        return $listaPredioDato;
    }
    public static function getPredioDatoByIdPredio($idPredio){
        $predioDato = PredioDato::where('idPredio', '=', $idPredio)->first();
        return $predioDato;
    }
    public function getPredioDatoByPredio($idPredio){
        $predioDato = PredioDato::where('idPredio', '=', $idPredio)->first();
        return $predioDato; 
    }
    //agregado Ruddy
    public static function getListPredioDatoByIdPredio($idPredio)
    {
        $listaPredioDato = PredioDato::where('idPredio','=',$idPredio)->get();
        return $listaPredioDato;
    }
}
