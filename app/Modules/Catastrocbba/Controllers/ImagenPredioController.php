<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\ImagenPredio;
use Illuminate\Support\Facades\DB;

class ImagenPredioController extends Controller
{
    public static $TIPO_CROQUIS="C";
    public static $TIPO_UBICACION="U";
    public static $TIPO_FACHADA="F";
    public static $TIPO_BLOQUE="B";
    public static $TIPO_MEJORA="M";
    public static $TIPO_AUTOCAD="A";
    public static $TIPO_OTROS="O";
    
	 public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $imagenpredios = ImagenPredio::get();
            $count = 0;
            foreach($imagenpredios as $imagenpredio){
            	$response["data"][$count]["type"] ="imagenpredio"; 
            	$response["data"][$count]["id"]=$imagenpredio->idImagenPredio;
            	$response["data"][$count]["attributes"]["idpredio"]=$imagenpredio->idPredio;
            	$response["data"][$count]["attributes"]["imagen"] = $imagenpredio->imagen;
            	$response["data"][$count]["attributes"]["idrelacion"] = $imagenpredio->idRelacion; 
            	$response["data"][$count]["attributes"]["tiporelacion"] = $imagenpredio->tipoRelacion;
            	$response["data"][$count]["attributes"]["estado"] = $imagenpredio->estado; 
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
            $imagenpredio = ImagenPredio::find($id);
            $statusCode = 200;
            /*$response = [ "usuario" => [
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'login' => $usuario->login
            ]];*/
            $response = array("data"=>array("type"=>"imagenpredio",
            								"id"=>$imagenpredio->idPredio,
            								"attributes"=>array(
	            								"imagen"=>$imagenpredio->imagen,
	            								"idRelacion" => $imagenpredio->idRelacion,
	                							"tipoRelacion" => $imagenpredio->tipoRelacion, "estado" => $imagenpredio->estado)));
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
    
    public static function getListImagenPredioByIdUsuario($idUsuario){
        $listaImagenPredio = DB::table('imagen_predio as ip')
            ->join('predio as p', 'p.idPredio', '=', 'ip.idPredio')
            ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('ip.*')
            ->where([['a.idUsuario', '=', $idUsuario],['ip.estado','like','AC']])
            ->get();
        return $listaImagenPredio;
    }
    public function getListImagenPredioByIdPredioIdTipoRelacion($idPredio,$tipoRelacion){
        return ImagenPredio::where([['idPredio', '=', $idPredio],['tipoRelacion','=',$tipoRelacion],['estado','like','AC']])->get();
    }

    //agregado Ruddy
    public static function getListImagenPredioByIdPredio($idPredio){
        return ImagenPredio::where([['idPredio', '=', $idPredio],['estado','like','AC']])->get();
    }

    public static function updateImagen(Request $request)
    {
        try {
            $input = $request->all();
            ImagenPredio::where('idImagenPredio',$input['idImagenPredio'])->update($input);
            
        } catch (\Exception $e) {
            return Response::json(array('success' => false, "ingreso"=>$input,'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
    /********REQUEST GET IMAGENES***********/
    public function getCroquisByIdPredio($idPredio){
        return ImagenPredio::where([['idPredio','=',$idPredio],['tipoRelacion','=',ImagenPredioController::$TIPO_CROQUIS],['estado','like','AC']])->first();
    }
    public function getURLCroquisByIdPredio($idPredio){
        $imagenPredio=$this->getCroquisByIdPredio($idPredio);
        if(!isset($imagenPredio["imagen"]) || strlen($imagenPredio["imagen"])==0)
            return "assets/no_disponible.png";
        else return "http://".$_SERVER["HTTP_HOST"]."/catastrocbba/catastrobackend/public/imagenes/".$imagenPredio->imagen;
    }
    public function getUbicacionByIdPredio($idPredio){
        return ImagenPredio::where([['idPredio','=',$idPredio],['tipoRelacion','=',ImagenPredioController::$TIPO_UBICACION],['estado','like','AC']])->first();
    }
    public function getURLUbicacionByIdPredio($idPredio){
        $imagenPredio=$this->getUbicacionByIdPredio($idPredio);
        if(!isset($imagenPredio["imagen"]) || strlen($imagenPredio["imagen"])==0)
            return "assets/no_disponible.png";
        else return "http://".$_SERVER["HTTP_HOST"]."/catastrocbba/catastrobackend/public/imagenes/".$imagenPredio->imagen;
    }
    public function getListaFachadaByIdPredio($idPredio){
        return ImagenPredio::where([['idPredio','=',$idPredio],['tipoRelacion','=',ImagenPredioController::$TIPO_FACHADA],['estado','like','AC']])->get();
    }
    public function getOtrosByIdPredio($idPredio){
        return ImagenPredio::where([['idPredio','=',$idPredio],['tipoRelacion','=',ImagenPredioController::$TIPO_OTROS],['estado','like','AC']])->first();
    }
    public function getURLFachadaUnoByIdPredio($idPredio){
        $listaImagenPredio=$this->getListaFachadaByIdPredio($idPredio);
        $contador=0;
        foreach ($listaImagenPredio as $imagenPredio){
            $contador++;
            if($contador==1){
                if(!isset($imagenPredio["imagen"]) || strlen($imagenPredio["imagen"])==0)
                    return "assets/no_disponible.png";
                else return "http://".$_SERVER["HTTP_HOST"]."/catastrocbba/catastrobackend/public/imagenes/".$imagenPredio->imagen;
            }
        }
        return "assets/no_disponible.png";
        
    }
    public function getURLFachadaDosByIdPredio($idPredio){
        $listaImagenPredio=$this->getListaFachadaByIdPredio($idPredio);
        $contador=0;
        foreach ($listaImagenPredio as $imagenPredio){
            $contador++;
            if($contador==2){
                if(!isset($imagenPredio["imagen"]) || strlen($imagenPredio["imagen"])==0)
                    return "assets/no_disponible.png";
                else return "http://".$_SERVER["HTTP_HOST"]."/catastrocbba/catastrobackend/public/imagenes/".$imagenPredio->imagen;
            }
        }
        return "assets/no_disponible.png";
    }
    

    public function getURLOtrosByIdPredio($idPredio){
        $imagenPredio=$this->getOtrosByIdPredio($idPredio);
        if(!isset($imagenPredio["imagen"]) || strlen($imagenPredio["imagen"])==0)
            return "assets/no_disponible.png";
        else return "http://".$_SERVER["HTTP_HOST"]."/catastrocbba/catastrobackend/public/imagenes/".$imagenPredio->imagen;
    }
    
    /***********************************/
}
