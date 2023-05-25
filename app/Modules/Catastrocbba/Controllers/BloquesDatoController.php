<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Modules\Catastrocbba\Models\BloquesDato;
use Illuminate\Support\Facades\DB;
use App\Modules\Catastrocbba\Models\ValoresBloque;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BloquesDatoController extends Controller
{
    public function showAll() {
    	try{

            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $bloquesDatos = BloquesDato::get();
            $count = 0;
            foreach($bloquesDatos as $bloquesDato){
            	$response["data"][$count]["type"] ="bloquesDato"; 
            	$response["data"][$count]["id"]=$bloquesDato->idBloquesDato;
            	$response["data"][$count]["attributes"]["numerobloque"]=$bloquesDato->numerobloque;
            	$response["data"][$count]["attributes"]["superficiebloque"] = $bloquesDato->superficieBloque;
            	$response["data"][$count]["attributes"]["anioconstruccion"] = $bloquesDato->anioConstruccion; 
            	$response["data"][$count]["attributes"]["cantidadpisos"]=$bloquesDato->cantidadPisos;
            	$response["data"][$count]["attributes"]["idcoeficienteUso"] = $bloquesDato->idCoeficienteUso;
            	$response["data"][$count]["attributes"]["idcoeficienteDepreciacion"] = $bloquesDato->idCoeficienteDepreciacion; 
            	$response["data"][$count]["attributes"]["observaciones"]=$bloquesDato->observaciones;
            	$response["data"][$count]["attributes"]["tipobloque"] = $bloquesDato->tipoBloque;
            	$response["data"][$count]["attributes"]["estado"] = $bloquesDato->estado; 
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
            $bloquesDato = BloquesDato::find($id);
            $statusCode = 200;
            $response = array("data"=>array("type"=>"bloquesDato",
            								"id"=>$bloquesDato->idBloqueDato,
            								"attributes"=>array(
	            								"numerobloque"=>$bloquesDato->numerobloque,
	            								"superficiebloque" => $bloquesDato->superficieBloque,
	            								"anioconstruccion"=>$bloquesDato->anioConstruccion,
	            								"cantidadpisos" => $bloquesDato->cantidadPisos,
	            								"idCoeficienteuso"=>$bloquesDato->idCoeficienteUso,
	            								"idCoeficientedepreciacion" => $bloquesDato->idCoeficienteDepreciacion,
	            								"observaciones"=>$bloquesDato->observaciones,
	            								"tipobloque" => $bloquesDato->tipoBloque,
	                							"estado" => $bloquesDato->estado)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }        
    }
    public static function getListBloquesDatoByIdUsuario($idUsuario){
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('predio as p', 'p.idPredio', '=', 'bd.idPredio')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('bd.*')
        ->where('a.idUsuario', '=', $idUsuario)->where('bd.estado','=','AC')
        ->get();
        return $listaBloquesDato;
    }
    public function getListBloquesDatoByIdUsuarioTEST($idUsuario){
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('predio as p', 'p.idPredio', '=', 'bd.idPredio')
        ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
        ->select('bd.*')
        ->where('a.idUsuario', '=', $idUsuario)->where('bd.estado','=','AC')
        ->get();
        return $listaBloquesDato;
    }
    public static function getListBloquesDatoByIdPredio($idPredio){
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('predio as p', 'p.idPredio', '=', 'bd.idPredio')
        ->select('bd.*')
        ->where([
            ['p.idPredio','=',$idPredio],
            ['bd.estado','=','AC']
        ])
        ->orWhere([
            ['p.idPredio','=',$idPredio],
            ['bd.estado','=','GE']
        ])
        ->get();
        return $listaBloquesDato;
    }
    public function store(Request $request){
        
        try{
            $input = $request->all();
            Log::info(" Datos en guardar bloque : idBloqueDato".$request->idBloqueDato." estado ".$request->estado." numerobloque ".$request->numerobloque." superficieBloque ".$request->superficieBloque." cantidadPisos ".$request->cantidadPisos." anioConstruccion ".$request->anioConstruccion." gestion ".$request->gestion." idCoeficienteUso".$request->idCoeficienteUso." campo cuando es mejora idTipoMejora ".$request->idTipoMejora);
            $id = DB::table('bloques_dato')->insertGetId($input);
       }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","last_insert_id"=>$id), 200);
    }
    public function delete(Request $request){
        $input = $request->all();
        try{
            
            $input['estado']="EL";
            BloquesDato::where('idBloqueDato', $input["idBloqueDato"])->update($input);
    
        }catch(\Exception $e){
            return Response::json(array('success' => false, "ingreso"=>$input,'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
    public function storeBloqueDatoAndValoresBloque(Request $request){
        try{
            $bloquesDatoJson=$request->input("bloquesDato");
            $bloquesDatoJson["estado"]="AC";
            $listaValoresBloqueJson=$request->input("listaValoresBloque");
            $idBloqueDato = DB::table('bloques_dato')->insertGetId($bloquesDatoJson);
            
            $listaValoresBloque=array();
            if($idBloqueDato!=null){
            
                foreach ($listaValoresBloqueJson as $valorBloqueTmp){
                    $valorBloque=new ValoresBloque();
                    $valorBloque->idBloqueDato=$idBloqueDato;
                    $valorBloque->idCaracteristicaBloque=$valorBloqueTmp["idCaracteristicaBloque"];
                    $valorBloque->orden=$valorBloqueTmp["orden"];
                    if($valorBloqueTmp["porcentaje"]>100)
                        $valorBloque->porcentaje=100;
                    else $valorBloque->porcentaje=$valorBloqueTmp["porcentaje"];
                    $valorBloque->puntaje=$valorBloqueTmp["puntaje"];
                    $valorBloque->estado=$valorBloqueTmp["estado"];
                    
                    $valorBloque->save();
                    $listaValoresBloque[]=$valorBloque;
                }
            
            }
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"idBloquesDato"=>null,"listaValoresBloque"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","idBloquesDato"=>$idBloqueDato,"listaValoresBloque"=>$listaValoresBloque), 200);
        
    }
    public function updateBloqueDatoAndValoresBloque(Request $request){
        
        try{
            $bloquesDatoJson=$request->input("bloquesDato");
            $listaValoresBloqueJson=$request->input("listaValoresBloque");
            
            BloquesDato::where('idPredio', $bloquesDatoJson["idBloqueDato"])->update($bloquesDatoJson);
            ValoresBloque::where('idBloqueDato','=' ,$bloquesDatoJson["idBloqueDato"])->delete();
        
            $listaValoresBloque=array();
            if($bloquesDatoJson["idBloqueDato"]!=null){
        
                foreach ($listaValoresBloqueJson as $valorBloqueTmp){
                    $valorBloque=new ValoresBloque();
                    $valorBloque->idBloqueDato=$bloquesDatoJson["idBloqueDato"];
                    $valorBloque->idCaracteristicaBloque=$valorBloqueTmp["idCaracteristicaBloque"];
                    $valorBloque->orden=$valorBloqueTmp["orden"];
                    $valorBloque->porcentaje=$valorBloqueTmp["porcentaje"];
                    $valorBloque->puntaje=$valorBloqueTmp["puntaje"];
                    $valorBloque->estado=$valorBloqueTmp["estado"];
        
                    $valorBloque->save();
                    $listaValoresBloque[]=$valorBloque;
                }
        
            }
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"listaValoresBloque"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK","listaValoresBloque"=>$listaValoresBloque), 200);
    }
    public function update(Request $request){
    
        try{
            $input = $request->all();
            Log::info(" Datos en actualzar bloque : idBloqueDato".$request->idBloqueDato." estado ".$request->estado." numerobloque ".$request->numerobloque." superficieBloque ".$request->superficieBloque." cantidadPisos ".$request->cantidadPisos." anioConstruccion ".$request->anioConstruccion." gestion ".$request->gestion." idCoeficienteUso".$request->idCoeficienteUso." campo cuando es mejora idTipoMejora ".$request->idTipoMejora);
            BloquesDato::where('idBloqueDato', $input["idBloqueDato"])->update($input);
            
        }catch(\Exception $e){
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
    public function getBloques($idPredio){
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('coeficiente_depreciacion as cd', 'cd.idCoeficienteDepreciacion', '=', 'bd.idCoeficienteDepreciacion')
        ->join('coeficiente_uso as cu', 'cu.idCoeficienteUso', '=', 'bd.idCoeficienteUso')
        ->select('bd.*','cd.descripcion as coeficienteDepreciacion','cu.descripcion as coeficienteUso')
        ->where('bd.idPredio','=',$idPredio)->where('bd.estado','=','AC')->where('bd.tipoBloque','=','0')->orderBy('numerobloque','asc')->orderBy('gestion','asc')
        ->get();
        return $listaBloquesDato;
    } 
    public function getMejoras($idPredio){
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('coeficiente_depreciacion as cd', 'cd.idCoeficienteDepreciacion', '=', 'bd.idCoeficienteDepreciacion')
        ->join('tipo_mejora as tm', 'tm.idTipoMejora', '=', 'bd.idTipoMejora')
        ->select('bd.*','cd.descripcion as coeficienteDepreciacion','tm.descripcion as tipoMejora')
        ->where('bd.idPredio','=',$idPredio)->where('bd.estado','=','AC')->where('bd.tipoBloque','=','1')->orderBy('tm.descripcion','asc')->orderBy('gestion','asc')
        ->get();
        return $listaBloquesDato;
    }
    
    //Nuevas funciones para bloques
    public function getListBloquesDatosMixByIdPredio($idPredio){

        $objetoGlobal = array("idPredio"=>$idPredio);
        //ESTADO AVALUO-NUMERO FORMULARIO
        $avaluoPredio = DB::table('predio as p')
        ->join('avaluo as a','a.idAvaluo','=','p.idAvaluo')
        ->select('a.*')
        ->where('p.idPredio','=',$idPredio)
        ->first();
        $datosAvaluo = array('estadoavaluo' => $avaluoPredio->estadoAvaluo , 'numeroformulario' => $avaluoPredio->numeroFormulario);
        $objetoGlobal["avaluodatos"] = $datosAvaluo;
        //COEFICIENTES
        $coeficientes = DB::table('coeficiente_uso')
        ->where([
            ['estado','=','AC']
        ])->orderBy('orden', 'asc')->get();
        $objetoGlobal["coeficientes"] = $coeficientes;
        //TIPO MEJORAS
        $tipomejoras = DB::table('tipo_mejora')
        ->where([
            ['estado','=','AC']
        ])->orderBy('orden', 'asc')->get();
        $objetoGlobal["coeficientes"] = $coeficientes;
        $objetoGlobal["tipomejoras"] = $tipomejoras;
        //TIPO CARACTERISTICAS
        $tipocaracteristicas = DB::table('tipo_caracteristicas')
        ->where([
            ['estado','=','AC']
        ])->orderBy('orden', 'asc')->get();
        foreach ($tipocaracteristicas as $tipocaracteristica) {
            $caracteristicasbloques = DB::table('caracteristicas_bloque')
            ->where([
                ['estado','=','AC'],
                ['idTipoCaracteristica','=',$tipocaracteristica->idTipoCaracteristica]
            ])->orderBy('orden', 'asc')->get();
            $tipocaracteristica->caracteristicasbloques = $caracteristicasbloques;
        }
        $objetoGlobal["tipocaracteristicas"] = $tipocaracteristicas;
        //BLOQUES DEL PREDIO
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('predio as p', 'p.idPredio', '=', 'bd.idPredio')
        ->select('bd.*')
        ->where([
            ['p.idPredio','=',$idPredio],
            ['bd.estado','=','AC']
        ])
        ->orWhere([
            ['p.idPredio','=',$idPredio],
            ['bd.estado','=','GE']
        ])
        ->get();

        foreach ($listaBloquesDato as $bloque) {
            $listValorBloque = DB::table('valores_bloque as vb')
            ->join('bloques_dato as bd', 'bd.idBloqueDato', '=', 'vb.idBloqueDato')
            ->select('vb.*')
            ->where([['vb.idBloqueDato', '=', $bloque->idBloqueDato],['vb.estado','=','AC']])
            ->get();
            $bloque->valoresbloque = $listValorBloque;
        }

        $objetoGlobal["listabloques"] = $listaBloquesDato;
        
        return Response::json($objetoGlobal, 200);
    }

    public function saveBloquesDatosNew(Request $request){
        
        DB::beginTransaction();
        try{
            $datos = $request->json()->all();
            foreach ($datos as $dato) {
                //BLOQUES
                $idBloqueDato = array_key_exists('idBloqueDato',$dato)==true?$dato['idBloqueDato']:null;
                $idPredio = array_key_exists('idPredio',$dato)==true?$dato['idPredio']:null;
                $numerobloque = array_key_exists('numerobloque',$dato)==true?$dato['numerobloque']:null;
                $superficieBloque = array_key_exists('superficieBloque',$dato)==true?$dato['superficieBloque']:null;
                $anioConstruccion = array_key_exists('anioConstruccion',$dato)==true?$dato['anioConstruccion']:null;
                $cantidadPisos = array_key_exists('cantidadPisos',$dato)==true?$dato['cantidadPisos']:null;
                $idCoeficienteUso = array_key_exists('idCoeficienteUso',$dato)==true?$dato['idCoeficienteUso']:null;
                $idCoeficienteDepreciacion = array_key_exists('idCoeficienteDepreciacion',$dato)==true?$dato['idCoeficienteDepreciacion']:null;
                $observaciones = array_key_exists('observaciones',$dato)==true?$dato['observaciones']:null;
                $tipoBloque = array_key_exists('tipoBloque',$dato)==true?$dato['tipoBloque']:null;
                $estado = array_key_exists('estado',$dato)==true?$dato['estado']:null;
                $gestion = array_key_exists('gestion',$dato)==true?$dato['gestion']:null;
                $idTipoMejora = array_key_exists('idTipoMejora',$dato)==true?$dato['idTipoMejora']:null;

                if($idPredio != null)//existe predio se guarda
                {
                    if($idBloqueDato == null)
                    {
                        //CREAR BLOQUE
                        $bloque = array(
                            'idBloqueDato' => $idBloqueDato,
                            'idPredio'=>$idPredio,
                            'numerobloque'=>$numerobloque,
                            'superficieBloque'=>$superficieBloque,
                            'anioConstruccion'=>$anioConstruccion,
                            'cantidadPisos'=>$cantidadPisos,
                            'idCoeficienteUso'=>$idCoeficienteUso,
                            'idCoeficienteDepreciacion'=>$idCoeficienteDepreciacion,
                            'observaciones'=>$observaciones,
                            'tipoBloque'=>$tipoBloque,
                            'estado'=>$estado,
                            'gestion'=>$gestion,
                            'idTipoMejora'=>$idTipoMejora
                        );
                        $idBloqueDatoThis = DB::table('bloques_dato')->insertGetId($bloque);

                        //VALORES BLOQUE
                        $valoresBloques = array_key_exists('valoresbloque',$dato)==true?$dato['valoresbloque']:array();
                        foreach ($valoresBloques as $valor) {

                            $idValorBloque = array_key_exists('idValorBloque',$valor)==true?$valor['idValorBloque']:null;
                            $idBloqueDatoThisVal = array_key_exists('idBloqueDato',$valor)==true?$valor['idBloqueDato']:null;
                            $idCaracteristicaBloque = array_key_exists('idCaracteristicaBloque',$valor)==true?$valor['idCaracteristicaBloque']:null;
                            $orden = array_key_exists('orden',$valor)==true?$valor['orden']:null;
                            $porcentaje = array_key_exists('porcentaje',$valor)==true?$valor['porcentaje']:null;
                            $puntaje = array_key_exists('puntaje',$valor)==true?$valor['puntaje']:null;
                            $estado = array_key_exists('estado',$valor)==true?$valor['estado']:null;

                            if($porcentaje == null)
                                $porcentaje = 0;

                            if($idCaracteristicaBloque != null)//todo bien el valor se puede guardar
                            {
                                if($idValorBloque == null)//se crea el valor bloque
                                {
                                    if($porcentaje > 0)
                                    {
                                        //CREAR VALOR BLOQUE
                                        $caracteristicaBloque = DB::table('caracteristicas_bloque')->where('idCaracteristicaBloque', $idCaracteristicaBloque)->first();
                                        $puntajeN = 0;
                                        if($porcentaje != null)
                                        {
                                            $puntajeCaracteristica = $caracteristicaBloque->puntaje;
                                            $porcentajeDecimal = $porcentaje/100;
                                            $puntajeN = round(($porcentajeDecimal*$puntajeCaracteristica),2);
                                        }
                                        else 
                                        {
                                            Log::info('El porcentaje llego null se guardo con 0');
                                        }

                                        $valorbloquenew = array(
                                            'idValorBloque' => $idValorBloque,
                                            'idBloqueDato' => $idBloqueDatoThis,
                                            'idCaracteristicaBloque' => $idCaracteristicaBloque,
                                            'orden' => $orden,
                                            'porcentaje' => $porcentaje,
                                            'puntaje' => $puntajeN,
                                            'estado' => $estado
                                        );
                                        $idValorBloqueThis = DB::table('valores_bloque')->insertGetId($valorbloquenew);
                                    }

                                }
                                else //se edita el valor bloque, al tratarse un nuevo bloque no deberia pasar
                                {
                                    //ACTUALIZAR VALOR BLOQUE
                                    $caracteristicaBloque = DB::table('caracteristicas_bloque')->where('idCaracteristicaBloque', $idCaracteristicaBloque)->first();
                                    $puntajeN = 0;
                                    if($porcentaje != null)
                                    {
                                        $puntajeCaracteristica = $caracteristicaBloque->puntaje;
                                        $porcentajeDecimal = $porcentaje/100;
                                        $puntajeN = round(($porcentajeDecimal*$puntajeCaracteristica),2);
                                    }
                                    else 
                                    {
                                        Log::info('El porcentaje llego null se guardo con 0');
                                    }
                                    $valorbloquenew = array(
                                        'idValorBloque' => $idValorBloque,
                                        'idBloqueDato' => $idBloqueDatoThis,
                                        'idCaracteristicaBloque' => $idCaracteristicaBloque,
                                        'orden' => $orden,
                                        'porcentaje' => $porcentaje,
                                        'puntaje' => $puntajeN,
                                        'estado' => $estado
                                    );
                                    DB::table('valores_bloque')->where('idValorBloque', $idValorBloque)->update($valorbloquenew);
                                }
                            }
                            else //mal no tiene un idcaracteristica no se puede guardar el valor bloque
                            {
                                Log::info('Error no se puede guardar el valor bloque tiene idcaracteristica null');
                            }
                        }

                        //END CREAR
                    }
                    else 
                    {
                        //UPDATE BLOQUE
                        $bloque = array(
                            'idBloqueDato' => $idBloqueDato,
                            'idPredio'=>$idPredio,
                            'numerobloque'=>$numerobloque,
                            'superficieBloque'=>$superficieBloque,
                            'anioConstruccion'=>$anioConstruccion,
                            'cantidadPisos'=>$cantidadPisos,
                            'idCoeficienteUso'=>$idCoeficienteUso,
                            'idCoeficienteDepreciacion'=>$idCoeficienteDepreciacion,
                            'observaciones'=>$observaciones,
                            'tipoBloque'=>$tipoBloque,
                            'estado'=>$estado,
                            'gestion'=>$gestion,
                            'idTipoMejora'=>$idTipoMejora
                        );
                        DB::table('bloques_dato')->where('idBloqueDato', $idBloqueDato)->update($bloque);

                        //VALORES BLOQUE
                        $valoresBloques = array_key_exists('valoresbloque',$dato)==true?$dato['valoresbloque']:array();
                        foreach ($valoresBloques as $valor) {

                            $idValorBloque = array_key_exists('idValorBloque',$valor)==true?$valor['idValorBloque']:null;
                            $idBloqueDatoThisVal = array_key_exists('idBloqueDato',$valor)==true?$valor['idBloqueDato']:null;
                            $idCaracteristicaBloque = array_key_exists('idCaracteristicaBloque',$valor)==true?$valor['idCaracteristicaBloque']:null;
                            $orden = array_key_exists('orden',$valor)==true?$valor['orden']:null;
                            $porcentaje = array_key_exists('porcentaje',$valor)==true?$valor['porcentaje']:null;
                            $puntaje = array_key_exists('puntaje',$valor)==true?$valor['puntaje']:null;
                            $estado = array_key_exists('estado',$valor)==true?$valor['estado']:null;

                            if($porcentaje == null)
                                $porcentaje = 0;
                            
                            if($idCaracteristicaBloque != null)//todo bien el valor se puede guardar
                            {
                                if($idValorBloque == null )//se crea el valor bloque
                                {
                                    if($porcentaje > 0)
                                    {
                                        //CREAR VALOR BLOQUE
                                        $caracteristicaBloque = DB::table('caracteristicas_bloque')->where('idCaracteristicaBloque', $idCaracteristicaBloque)->first();
                                        $puntajeN = 0;
                                        if($porcentaje != null)
                                        {
                                            $puntajeCaracteristica = $caracteristicaBloque->puntaje;
                                            $porcentajeDecimal = $porcentaje/100;
                                            $puntajeN = round(($porcentajeDecimal*$puntajeCaracteristica),2);
                                        }
                                        else 
                                        {
                                            Log::info('El porcentaje llego null se guardo con 0');
                                        }

                                        $valorbloquenew = array(
                                            'idValorBloque' => $idValorBloque,
                                            'idBloqueDato' => $idBloqueDato,
                                            'idCaracteristicaBloque' => $idCaracteristicaBloque,
                                            'orden' => $orden,
                                            'porcentaje' => $porcentaje,
                                            'puntaje' => $puntajeN,
                                            'estado' => $estado
                                        );
                                        $idValorBloqueThis = DB::table('valores_bloque')->insertGetId($valorbloquenew);
                                    }

                                }
                                else //se edita el valor bloque
                                {
                                    //ACTUALIZAR VALOR BLOQUE
                                    $caracteristicaBloque = DB::table('caracteristicas_bloque')->where('idCaracteristicaBloque', $idCaracteristicaBloque)->first();
                                    $puntajeN = 0;
                                    if($porcentaje != null)
                                    {
                                        $puntajeCaracteristica = $caracteristicaBloque->puntaje;
                                        $porcentajeDecimal = $porcentaje/100;
                                        $puntajeN = round(($porcentajeDecimal*$puntajeCaracteristica),2);
                                    }
                                    else 
                                    {
                                        Log::info('El porcentaje llego null se guardo con 0');
                                    }
                                    $valorbloquenew = array(
                                        'idValorBloque' => $idValorBloque,
                                        'idBloqueDato' => $idBloqueDato,
                                        'idCaracteristicaBloque' => $idCaracteristicaBloque,
                                        'orden' => $orden,
                                        'porcentaje' => $porcentaje,
                                        'puntaje' => $puntajeN,
                                        'estado' => $estado
                                    );
                                    DB::table('valores_bloque')->where('idValorBloque', $idValorBloque)->update($valorbloquenew);
                                }
                            }
                            else //mal no tiene un idcaracteristica no se puede guardar el valor bloque
                            {
                                Log::info('Error no se puede guardar el valor bloque tiene idcaracteristica null');
                            }
                        }
                        //END UPDATEBLOQUE
                    }
                }
                else //si el idPredio es null algo esta mal
                {
                    Log::info('el idPredio recivido para guardar fue null, no se guardo el bloque');
                }
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('error en save bloques new '.$e->__toString());
            return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id"=>null), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }

    public function getOnlyListBloquesDatosByIdPredio($idPredio){

        $objetoGlobal = array("idPredio"=>$idPredio);
        //BLOQUES DEL PREDIO
        $listaBloquesDato = DB::table('bloques_dato as bd')
        ->join('predio as p', 'p.idPredio', '=', 'bd.idPredio')
        ->select('bd.*')
        ->where([
            ['p.idPredio','=',$idPredio],
            ['bd.estado','=','AC']
        ])
        ->orWhere([
            ['p.idPredio','=',$idPredio],
            ['bd.estado','=','GE']
        ])
        ->get();

        foreach ($listaBloquesDato as $bloque) {
            $listValorBloque = DB::table('valores_bloque as vb')
            ->join('bloques_dato as bd', 'bd.idBloqueDato', '=', 'vb.idBloqueDato')
            ->select('vb.*')
            ->where([['vb.idBloqueDato', '=', $bloque->idBloqueDato],['vb.estado','=','AC']])
            ->get();
            $bloque->valoresbloque = $listValorBloque;
        }

        $objetoGlobal["listabloques"] = $listaBloquesDato;
        
        return Response::json($objetoGlobal, 200);
    }


}
