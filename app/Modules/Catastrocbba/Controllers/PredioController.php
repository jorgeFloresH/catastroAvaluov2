<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\Predio;
use App\Modules\Catastrocbba\Models\Avaluo;
use App\Modules\Catastrocbba\Models\BloquesDato;
use App\Modules\Catastrocbba\Models\User;
use App\Modules\Catastrocbba\Models\ImagenPredio;
use App\Modules\Catastrocbba\Controllers\ImagenPredioController;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

//agregado RUddy
use Illuminate\Support\Facades\File;

class PredioController extends Controller
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
                $response["data"][$count]["attributes"]["bloque"] = $predio->piso; 
                $response["data"][$count]["attributes"]["planta"]=$predio->planta;
                $response["data"][$count]["attributes"]["departamento"] = $predio->departamento;
                $response["data"][$count]["attributes"]["latitud"] = $predio->latitud; 
                $response["data"][$count]["attributes"]["longitud"]=$predio->longitud;
                $response["data"][$count]["attributes"]["codigoCatastral"] = $predio->codigoCatastral;
                $response["data"][$count]["attributes"]["goecodigo"] = $predio->goecodigo; 
                $response["data"][$count]["attributes"]["idavaluo"]=$predio->idAvaluo;
                $response["data"][$count]["attributes"]["estado"] = $predio->estado;
                $response["data"][$count]["attributes"]["pmc"] = $predio->pmc;
                 
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
                                                "bloque" => $predio->piso,
                                                "planta" => $predio->planta,
                                                "departamento"=>$predio->departamento,
                                                "latitud" => $predio->latitud,
                                                "longitud" => $predio->longitud,
                                                "codigocatastral"=>$predio->codigoCatastral,
                                                "nombreedificio" => $predio->nombreEdificio,
                                                "goecodigo" => $predio->goecodigo,
                                                "idAvaluo"=>$predio->idAvaluo,
                                                "estado" => $predio->estado,
                                                "pmc" => $predio->pmc,
                                                )));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }
    
    /*public function save(Request $request){
        try{
            $input = $request->all();
            $id = DB::table('predio')->insertGetId(
                $input
            );
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"idPredio"=>0), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","idPredio"=>$id), 200);
    }*/
    
    
    public static function getListPredioByIdUsuario($idUsuario){
        
        $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->leftJoin('users as u','u.id','=','a.idUsuario')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.idUsuario', '=', $idUsuario],
                ['u.estado','like','AC'],
                ['a.estado','like','AC']
                ])
            ->orderBy('a.fechaRegistro','desc')
            ->get();
        $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
        return $listaPredios;
    }

    public static function getListPredioByIdUsuarioAndroid($idUsuario){
        $listaPredios = DB::table('predio as p')
            ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*')
            ->where('a.idUsuario', '=', $idUsuario)
            ->get();
        return $listaPredios;
    }
    
    public function store(Request $request){
         try{
            $avaluo = new Avaluo;
            $avaluo->idUsuario = $request->input('idUsuario');
            $avaluo->estado = "AC";
            $avaluo->fechaRegistro = date("Y-m-d H:i:s");
            $avaluo->numeroHabilitado = 0;
            $avaluo->estadoAvaluo = 0;
            $avaluo->estadoImpresion = 0;
            $avaluo->superficiePredio = 0;
            $avaluo->valorTerreno = 0;
            $avaluo->save();
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }        

        try{
            //$input = $request->all();
            $input = $request->except('idUsuario');
            $input["idAvaluo"]=$avaluo->idAvaluo;

            if (empty($input["codigoBloque"]) || is_null($input["codigoBloque"])) {
                $input["codigoBloque"] = 00;
            }
            if (empty($input["codigoPlanta"]) || is_null($input["codigoPlanta"])) {
                $input["codigoPlanta"] = 000;
            }
            if (empty($input["codigoUnidad"]) || is_null($input["codigoUnidad"])) {
                $input["codigoUnidad"] = 000;
            }

            $id = DB::table('predio')->insertGetId($input);

            //AGREGADO AL CREARSE UN PREDIO ESTE CREARA UN BLOQUE DATO INICIAL CON ESTADO GE PARA EL FRONTEND RUDDY
            $bloqueinicial = new BloquesDato;
            $bloqueinicial->idPredio = $id;//idPredio creado recien
            $bloqueinicial->estado = 'GE';
            $bloqueinicial->idCoeficienteUso = 3;
            $bloqueinicial->idCoeficienteDepreciacion = 1;
            $bloqueinicial->tipoBloque = 0;
            $bloqueinicial->numerobloque = '';
            $bloqueinicial->superficieBloque = 0;
            $bloqueinicial->anioConstruccion = 0;
            $bloqueinicial->cantidadPisos = 0;
            $bloqueinicial->gestion = 0;
            $bloqueinicial->save();


       }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","last_insert_id"=>$id), 200);
    }    	
    public function update(Request $request){
    
        try{
            $input = $request->all();
            
            Predio::where('idPredio', $input["idPredio"])->update($input);
            
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
    public function storeAvaluoAndPredio(Request $request){
    
        $avaluoJson=$request->input("avaluo");
        $predioJson=$request->input("predio");
        $idAvaluo = DB::table('avaluo')->insertGetId($avaluoJson);
        if($idAvaluo!=null){
            $arrayPredio=$predioJson;
            $arrayPredio["idAvaluo"]=$idAvaluo;
            $idPredio = DB::table('predio')->insertGetId($arrayPredio);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","idAvaluo"=>$idAvaluo,"idPredio"=>$idPredio), 200);
    }
    /*public function uploadPhotoPredio(Request $request){
		$response = array();
		$server_ip = gethostbyname(gethostname());
		
		$fileName = $request->file('image');	
		
		if (isset($fileName)) {
            $destinationPath = storage_path().'/uploads/';
			$request->file('image')->move($destinationPath, $fileName->getClientOriginalName());
			$idPredio = $this->reemplazarCaracteresEspeciales($request->input("idPredio")); 
            $tipoRelacion = $this->reemplazarCaracteresEspeciales($request->input("tipoRelacion")); 
            $idRelacion = $this->reemplazarCaracteresEspeciales($request->input("idRelacion"));
            $nombreImagen=$this->reemplazarCaracteresEspeciales($fileName->getClientOriginalName());
			
			$response['imagen'] = $nombreImagen;
            $response['tipoRelacion']=$tipoRelacion;
            $response['idPredio']=$idPredio;
            $imagenPredio=new ImagenPredio();
            $imagenPredio->idPredio=(int)$idPredio;
            $imagenPredio->imagen='imagen1.jpg';
            $imagenPredio->tipoRelacion="$tipoRelacion";
            $imagenPredio->idRelacion=(int)$idRelacion;
            $imagenPredio->estado="AC";
			
			$listaImagenesPredio=array();

			
			try {
                // Throws exception incase file is not being moved
                $request->file('image')->move($destinationPath, $fileName->getClientOriginalName());
				if(!$imagenPredio->save()){
                    $response['message'] = 'No se pudo guadar en la base de datos';
                    $response['error'] = true;
                }else{
					$mensajeGrabado = "exito en base de datos";
				}                      
				$this->redimensionarImagen($destinationPath);
                
            } catch (\Exception $e) {
                // Exception occurred. Make error flag true
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
			
			return Response::json(array('mensaje' => $idPredio,
					"idImagenPredio"=>$tipoRelacion,
					"idRelacion"=>$idRelacion,
					"tipoRelacion"=>$tipoRelacion,
					"nombreImagen"=>$nombreImagen,
					"ruta"=>$destinationPath.$fileName->getClientOriginalName()
        ), 200);
        } else {
            // File parameter is missing
            $response['error'] = true;
            $response['message'] = 'No se recivio ningun archivo!';
        }
        
       
    }*/
    public function uploadFile(Request $request){
        
        // array for final json respone
        $response = array();
        
        // getting server ip address
        $server_ip = gethostbyname(gethostname());
    
        if (isset($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newName = $this->cambiarNombreImagen(basename($_FILES['image']['name']),$ext);

            $target_path = storage_path().'/uploads/' . $newName;
        
            // reading other post parameters
            $idPredio = $this->reemplazarCaracteresEspeciales($request->input("idPredio")); 
            $tipoRelacion = $this->reemplazarCaracteresEspeciales($request->input("tipoRelacion")); 
            $idRelacion = $this->reemplazarCaracteresEspeciales($request->input("idRelacion"));
            $nombreImagen=$newName;
        
            $response['imagen'] = $nombreImagen;
            $response['tipoRelacion']=$tipoRelacion;
            $response['idPredio']=$idPredio;
            $imagenPredio=new ImagenPredio();
            $imagenPredio->idPredio=$idPredio;
            $imagenPredio->imagen=$nombreImagen;
            $imagenPredio->tipoRelacion="$tipoRelacion";
            $imagenPredio->idRelacion=$idRelacion;
            $imagenPredio->estado="AC";
            
            $listaImagenesPredio=array();
            if($tipoRelacion=="C" ||  $tipoRelacion=="O"){
                $imagenPredioController=new ImagenPredioController();
                $listaImagenesPredio=$imagenPredioController->getListImagenPredioByIdPredioIdTipoRelacion($idPredio,$tipoRelacion);
            }
            
        
            try {
                // Throws exception incase file is not being moved
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
					
					
                    // make error flag true
                    $response['error'] = true;
                    $response['message'] = 'No se puede mover el archivo!';
                }else{
                    if($_FILES["image"]["type"]=="image/jpeg")
                        $this->redimensionarImagen($target_path);
                }
        
                if(!$imagenPredio->save()){
                    $response['message'] = 'No se pudo guadar en la base de datos';
                    $response['error'] = true;
                }else{
                    
                    
                        foreach ($listaImagenesPredio as $imagenPredioElement){
                            $imagenPredioParcial=ImagenPredio::find($imagenPredioElement->idImagenPredio);
                            $imagenPredioParcial->delete();
                        }
                    
                    
                    // File successfully uploaded
                    $response['message'] = 'Archivo subido satisfactoriamente!';
                    $response['error'] = false;
                    $response['idImagenPredio'] = $imagenPredio->idImagenPredio;
                    $response['idRelacion'] = $imagenPredio->idRelacion;
                    $response['nombreImagen'] = $imagenPredio->imagen;
                }
                
            } catch (\Exception $e) {
                // Exception occurred. Make error flag true
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
        } else {
            // File parameter is missing
            $response['error'] = true;
            $response['message'] = 'No se recivio ningun archivo!';
        }
        
        // Echo final json response to client
        //echo json_encode($response);
        
        
        return Response::json(array('success' => !$response['error'], 
            'mensaje' => $this->reemplazarCaracteresEspeciales($response['message']),
            "idImagenPredio"=>$this->reemplazarCaracteresEspeciales($response['idImagenPredio']),
            "idRelacion"=>$this->reemplazarCaracteresEspeciales($response['idRelacion']),
            "nombreImagen"=>$this->reemplazarCaracteresEspeciales($response['nombreImagen'])
        ), 200);
    }


    //agregado Ruddy
    public function migrarImagenes(Request $request)
    {
        $input = $request->all();


        try {


             for ($i=0; $i < count($input['imagenes']); $i++) { 
            

                //ruta de las imagenes en el servidor www.catastro.com
                $target_path_server = "http://www.catastrocbba.com/catastroBackend/storage/uploads/".$input['imagenes'][$i];

                //ruta del servidor local al que se copiaran las imagenes
                 $target_path_local = storage_path().'/uploads/'.$input['imagenes'][$i];


                //copiado de las imagenes
                $copy =copy($target_path_server, $target_path_local);


              }
            
        } catch (\Exception $e) {
                
                //$response['error'] = true;
                //$response['message'] = $e->getMessage();
				return Response::json(array('success'=>false,'mensaje'=>"Exception","stackTrace"=>$e->__toString()));
        }
		
		return Response::json(array('success'=> true,'mensaje'=>true),200);
    }

    public static function migrarImagenesFtp($idPredio)
    {
        $res = false;

        try {

            

            $listaImagenesDB = DB::table('imagen_predio as i')
                ->select('i.*')
                ->where([
                    ['i.estado', 'like', 'AC'],
                    ['i.idPredio','=',$idPredio]
                    ])
                ->get();

            if (count($listaImagenesDB) == 0) {
                return true;
            }


            foreach ($listaImagenesDB as $imagen) {
                $ruta_servidor_catastro = "/catastroBackend/storage/uploads/";
                $remote_file = $ruta_servidor_catastro.$imagen->imagen;
                

                //$ftp_host = "192.168.1.33";
                //$ftp_user_name = "ruddy";
                //$ftp_user_pass = "1234";
                //$ftp_host = "200.58.83.87";
                $ftp_host = "186.121.246.219";//nueva ruta del servidor de catastro
                $ftp_user_name = "ftpcatastro";
                $ftp_user_pass = "temporal.1";

                $local_file = storage_path().'/uploads/'.$imagen->imagen;
                

                $connect_it = ftp_connect($ftp_host);

                $login_result = ftp_login($connect_it, $ftp_user_name, $ftp_user_pass);

                if (ftp_put($connect_it, $remote_file, $local_file, FTP_BINARY)) {
                    $res = true;
                    
                }
                else
                {
                    $res = false;
                    ftp_close($connect_it);
                    return $res;
                }

                ftp_close($connect_it);


            }


            
        } catch (\Exception $e) {
                return $res;
                //return Response::json(array('success'=>false,'mensaje'=>"Exception","stackTrace"=>$e->__toString()));
        }
        return $res;
        
    }
    
    private function redimensionarImagen($rutaImagenOriginal){
        
        //$rutaImagenOriginal="./imagen/aprilia classic.jpg";
        
        //Creamos una variable imagen a partir de la imagen original
        $img_original = imagecreatefromjpeg($rutaImagenOriginal);
        
        //Se define el maximo ancho y alto que tendra la imagen final
        $max_ancho = 1000;
        $max_alto = 1000;
        
        //Ancho y alto de la imagen original
        list($ancho,$alto)=getimagesize($rutaImagenOriginal);
        
        //Se calcula ancho y alto de la imagen final
        $x_ratio = $max_ancho / $ancho;
        $y_ratio = $max_alto / $alto;
        
        
        
        //Si el ancho y el alto de la imagen no superan los maximos,
        //ancho final y alto final son los que tiene actualmente
        if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        }
        /*
         * si proporcion horizontal*alto mayor que el alto maximo,
         * alto final es alto por la proporcion horizontal
         * es decir, le quitamos al ancho, la misma proporcion que
         * le quitamos al alto
         *
         */
        elseif (($x_ratio * $alto) < $max_alto){
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $max_ancho;
        }
        /*
         * Igual que antes pero a la inversa
         */
        else{
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $max_alto;
        }
        
        //Creamos una imagen en blanco de tama�o $ancho_final  por $alto_final .
        $tmp=imagecreatetruecolor($ancho_final,$alto_final);
        
        //Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
        imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
        
        //Se destruye variable $img_original para liberar memoria
        imagedestroy($img_original);
        
        $calidad=70;
        //Se crea la imagen final en el directorio indicado
        imagejpeg($tmp,$rutaImagenOriginal,$calidad);
        
    }
    private function reemplazarCaracteresEspeciales($texto){
        $texto=str_replace("\n", "", $texto);
        $texto=str_replace("\t", "", $texto);
        $texto=str_replace("\r", "", $texto);
        return $texto;
    }

    //agregado Ruddy
    private function cambiarNombreImagen($nombre,$ext)
    {
        $fechaAuxiliar = date("YmdHis");
        $res = "img".$fechaAuxiliar.".".$ext;
        return $res;
    }


    //modificado Ruddy
    public static function getListPredioByIdUsuarioAndCodCatastral(Request $request){
        $idUsuarioJson=$request->input("idUsuario");
        $codigoCatastralJson=$request->input("codigoCatastral");
        $tipoUsuario = $request->input("tipoUsuario");

        $listaPredios;

        if ($tipoUsuario == 0) {
            $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.idUsuario', '=', $idUsuarioJson],
                ['a.estado','like','AC'],
                ['p.codigoCatastral','like',$codigoCatastralJson.'%']
            ])
            ->get();
            $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
            return $listaPredios;
        }
        if ($tipoUsuario == 1 || $tipoUsuario == 2) {
            $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.estado','like','AC'], 
                ['p.codigoCatastral','like',$codigoCatastralJson.'%']
            ])
            ->get();
            $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
            return $listaPredios;
        }
       
    }
    public static function getListPredioByIdUsuarioAndNroFormulario(Request $request){
        $idUsuarioJson=$request->input("idUsuario");
        $numeroFormularioJson=$request->input("numeroFormulario");
        $tipoUsuario = $request->input("tipoUsuario");
        $listaPredios;

        if ($tipoUsuario == 0) {
            $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.idUsuario', '=', $idUsuarioJson],
                ['a.estado','like','AC'], 
                ['a.numeroFormulario','=',$numeroFormularioJson]
                ])
            ->get();
            $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
            return $listaPredios;
        }
        if ($tipoUsuario == 1 || $tipoUsuario == 2) {
            $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.estado','like','AC'], 
                ['a.numeroFormulario','=',$numeroFormularioJson]
                ])
            ->get();
            $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
            return $listaPredios;
        }
    }
    public static function getListPredioByIdUsuarioAndApellido(Request $request){
        $idUsuarioJson=$request->input("idUsuario");
        $apellidoUnoJson=$request->input("apellidoUno");
        $tipoUsuario = $request->input("tipoUsuario");
        $listaPredios;

        if ($tipoUsuario == 0) {
            $listaPredios = DB::table('predio as p')
            ->join('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion')
            ->where([['a.idUsuario', '=', $idUsuarioJson],['a.estado','like','AC'], ['dp.apellidoUno','like',$apellidoUnoJson.'%'],['dp.estado','=','AC']])
            ->orwhere([['a.idUsuario', '=', $idUsuarioJson],['a.estado','like','AC'], ['dp.denominacion', 'like', $apellidoUnoJson .'%'],['dp.estado','=','AC']])
            ->get();
            return $listaPredios;
        }
        if ($tipoUsuario == 1 || $tipoUsuario == 2) {
            $listaPredios = DB::table('predio as p')
            ->join('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion')
            ->where([['a.estado','like','AC'], ['dp.apellidoUno','like',$apellidoUnoJson.'%'],['dp.estado','=','AC']])
            ->orwhere([['a.estado','like','AC'], ['dp.denominacion', 'like', $apellidoUnoJson .'%'],['dp.estado','=','AC']])
            ->get();
            return $listaPredios;
        }
        
    }


    //Agregado Ruddy
    public static function getListPredioByIdUsuarioAndNumeroInmuebleAndTipoUsuario(Request $request)
    {
        $idUsuarioJson = $request->input("idUsuario");
        $tipoUsuario = $request->input("tipoUsuario");
        $numeroInmueble = $request->input("numeroInmueble");
       
        $listaPredios;

        if($tipoUsuario == 0)
        {    
           $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.idUsuario', '=', $idUsuarioJson], 
                ['p.numeroInmueble','=',$numeroInmueble],
                ['a.estado','like','AC']
            ])
            ->get();
        }
        if($tipoUsuario == 1 || $tipoUsuario == 2)
        {
            $listaPredios = DB::table('predio as p')
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['p.numeroInmueble','=',$numeroInmueble],
                ['a.estado','like','AC']
            ])
            ->get();
        }
        $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
        return $listaPredios;
    }


    public static function getListPrediobyIdUsuarioAndNombreAndApellidoAndTipoUsuario(Request $request)
    {

        $idUsuarioJson = $request->input("idUsuario");
        $nombresJson = $request->input("nombres");
        $apellidoUnoJson = $request->input("apellidoUno");
        $tipoUsuario = $request->input("tipoUsuario");
        $listaPredios = null;

        if($tipoUsuario == 0)
        {
            if ($nombresJson == null && $apellidoUnoJson != null) {
                $listaPredios = DB::table('predio as p')
                ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
                ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
                ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion')
                ->where([
                    ['a.idUsuario', '=', $idUsuarioJson],
                    ['a.estado','like','AC'],
                    ['dp.apellidoUno','like',$apellidoUnoJson.'%'],
                    ['dp.estado','=','AC']
                    ])
                ->orwhere([
                    ['a.idUsuario', '=', $idUsuarioJson],
                    ['a.estado','like','AC'],
                     ['dp.denominacion', 'like', $apellidoUnoJson .'%'],
                     ['dp.estado','=','AC']
                     ])
                ->get();
                return $listaPredios;
            }
            if ($apellidoUnoJson == null && $nombresJson != null) {
                $listaPredios = DB::table('predio as p')
                ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
                ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
                ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion')
                ->where([['a.idUsuario', '=', $idUsuarioJson],['a.estado','like','AC'],['dp.nombres','like',$nombresJson.'%'],['dp.estado','=','AC']])
                ->orwhere([['a.idUsuario', '=', $idUsuarioJson],['a.estado','like','AC'], ['dp.denominacion', 'like', $nombresJson .'%'],['dp.estado','=','AC']])
                ->get();
                return $listaPredios;
            }
            if($nombresJson == null && $apellidoUnoJson == null)
            {
                return Response::json(array());
            }
        }
        if($tipoUsuario == 1 || $tipoUsuario == 2)
        {
            if ($nombresJson == null && $apellidoUnoJson != null) {
                $listaPredios = DB::table('predio as p')
                ->join('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
                ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
                ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion')
                ->where([['a.estado','like','AC'], ['dp.apellidoUno','like',$apellidoUnoJson.'%'],['dp.estado','=','AC']])
                ->orwhere([['a.estado','like','AC'], ['dp.denominacion', 'like', $apellidoUnoJson .'%'],['dp.estado','=','AC']])
                ->get();
                return $listaPredios;
            }
            if ($apellidoUnoJson == null && $nombresJson != null) {
                $listaPredios = DB::table('predio as p')
                ->join('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
                ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
                ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion')
                ->where([['a.estado','like','AC'],['dp.nombres','like',$nombresJson.'%'],['dp.estado','=','AC']])
                ->orwhere([['a.estado','like','AC'], ['dp.denominacion', 'like', $nombresJson .'%'],['dp.estado','=','AC']])
                ->get();
                return $listaPredios;
            }
            if($nombresJson == null && $apellidoUnoJson == null)
            {
                return Response::json(array());
            }
        }
        

    }



    public static function getListPredioByIdUsuario2(Request $request){
        $idUsuario = $request->input("idUsuario");
        $tipoUsuario = $request->input("tipoUsuario");
        $limiteConsulta = $request->input("limiteConsulta");
        $listaPredios;
        if ($tipoUsuario == 0) {
            $listaPredios = DB::table('predio as p')
            ->distinct()
            ->leftJoin('datos_propietario as dp', 'dp.idPredio', '=', 'p.idPredio')
            ->leftJoin('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->leftJoin('users as u','u.id','=','a.idUsuario')
            ->select('p.*', 'a.fechaRegistro', 'a.numeroFormulario', 'dp.apellidoUno', 'dp.apellidoDos','dp.nombres','dp.denominacion','dp.estado as dpestado')
            ->where([
                ['a.idUsuario', '=', $idUsuario],
                ['u.estado','like','AC'],
                ['a.estado','like','AC']
                ])
            ->orderBy('a.fechaRegistro','desc')
            ->limit($limiteConsulta)
            ->get();
            //dd($listaPredios);
            $listaPredios = PredioController::filtrarDatosPropietarioByEstadoAndPredio($listaPredios);
            return $listaPredios;
        }
        if ($tipoUsuario == 1) {
            return Response::json(array());
        }
        if ($tipoUsuario == 2) {
            return Response::json(array());
        }
       
    }

    //agregado Ruddy
    public static function getListPredioByIdAvaluo($idAvaluo)
    {
        $listaPredios = DB::table('predio as p')
                ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
                ->select('p.*')
                ->where([['a.estado','like','AC'], ['p.idAvaluo','=',$idAvaluo]])
                ->get();
                return $listaPredios;
    }

    public static function filtrarDatosPropietarioByEstadoAndPredio($lista)
    {
        $res = array();
        foreach ($lista as $pro) {
            $bandera = false;
            foreach ($res as $pro2) {
                if($pro->idPredio == $pro2->idPredio)
                {
                    $bandera = true;
                    break;
                }
            }

            if($bandera == false && $pro->dpestado != 'EL')
            {
                array_push($res,$pro);
            }

        }
        return $res;
    }
    
}
