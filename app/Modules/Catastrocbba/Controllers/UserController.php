<?php
namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Libraries\PhpMailer\MyPHPMailer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Modules\Catastrocbba\Models\Avaluo;
use App\Modules\Catastrocbba\Models\BloquesDato;
use App\Modules\Catastrocbba\Models\CaracteristicasBloque;
use App\Modules\Catastrocbba\Models\CoeficienteDepreciacion;
use App\Modules\Catastrocbba\Models\CoeficienteTopografico;
use App\Modules\Catastrocbba\Models\CoeficienteUso;
use App\Modules\Catastrocbba\Models\DatosPropietario;
use App\Modules\Catastrocbba\Models\FormaPredio;
use App\Modules\Catastrocbba\Models\ImagenPredio;
use App\Modules\Catastrocbba\Models\MaterialVium;
use App\Modules\Catastrocbba\Models\Predio;
use App\Modules\Catastrocbba\Models\PredioDato;
use App\Modules\Catastrocbba\Models\PredioServicio;
use App\Modules\Catastrocbba\Models\Servicio;
use App\Modules\Catastrocbba\Models\TipoCaracteristica;
use App\Modules\Catastrocbba\Models\TipologiasConstructiva;
use App\Modules\Catastrocbba\Models\TipologiasMejora;
use App\Modules\Catastrocbba\Models\TipoMejora;
use App\Modules\Catastrocbba\Models\UbicacionPredio;
use App\Modules\Catastrocbba\Models\User;
use App\Modules\Catastrocbba\Models\ValoresBloque;
use App\Modules\Catastrocbba\Models\ZonaHomogenea;
use App\Modules\Catastrocbba\Models\Migracion;


class UserController extends Controller
{
    
    public function showAll() {
        try{
    
            $response = [
                'data' => []
            ];
            $statusCode = 200;
            $usuarios = User::get();
            $count = 0;
            foreach($usuarios as $usuario){
                $response["data"][$count]["type"] ="user";
                $response["data"][$count]["id"]=$usuario->id;
                $response["data"][$count]["attributes"]["nombres"]=$usuario->nombres;
                $response["data"][$count]["attributes"]["apellidos"] = $usuario->apellidos;
                $response["data"][$count]["attributes"]["tipoUsuario"] = $usuario->tipoUsuario;
                $response["data"][$count]["attributes"]["login"] = $usuario->login;
                $response["data"][$count]["attributes"]["estado"] = $usuario->estado;
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
            $usuario = User::find($id);
            $statusCode = 200;
            /*$response = [ "usuario" => [
             'nombres' => $usuario->nombres,
             'apellidos' => $usuario->apellidos,
             'login' => $usuario->login
            ]];*/
            $response = array("data"=>array("type"=>"user",
                "id"=>$usuario->id,
                "attributes"=>array(
                    "nombres"=>$usuario->nombres,
                    "apellidos" => $usuario->apellidos,
                    "login" => $usuario->login)));
        }catch(\Exception $e){
            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
    }

    //agregado Ruddy
    public function showNombreApellido(Request $request)
    {
        try{

            $nombres = $request->input("nombres");
            $apellidos = $request->input("apellidos");
    
            $response = [
                'data' => []
            ];
            $statusCode = 200;

            if ($nombres != "" && $apellidos == "") {
                $usuarios = DB::table('users as u')
                ->select('u.*')
                ->where([['u.nombres', 'like', $nombres.'%']])
                ->get();
            }
            else if ($nombres == "" && $apellidos != "") {
                $usuarios = DB::table('users as u')
                ->select('u.*')
                ->where([['u.apellidos', 'like', $apellidos.'%']])
                ->get();
            }
            else if ($nombres != "" && $apellidos != "") {
                $usuarios = DB::table('users as u')
                ->select('u.*')
                ->where([['u.nombres', 'like', $nombres.'%'],['u.apellidos','like',$apellidos.'%']])
                ->get();
            }

            if ($nombres != "" || $apellidos != "") {
                $count = 0;
                foreach($usuarios as $usuario){
                    $response["data"][$count]["type"] ="user";
                    $response["data"][$count]["id"]=$usuario->id;
                    $response["data"][$count]["attributes"]["nombres"]=$usuario->nombres;
                    $response["data"][$count]["attributes"]["apellidos"] = $usuario->apellidos;
                    $response["data"][$count]["attributes"]["tipoUsuario"] = $usuario->tipoUsuario;
                    $response["data"][$count]["attributes"]["estado"] = $usuario->estado;
                    $response["data"][$count]["attributes"]["login"] = $usuario->login;
                    $count = $count + 1;
                }
            }
        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
    }

    public function showEmail(Request $request)
    {
        try{

            $email = $request->input("email");
    
            $response = [
                'data' => []
            ];
            $statusCode = 200;

             if ($email != "") {
                $usuarios = DB::table('users as u')
                ->select('u.*')
                ->where([['u.email', 'like', $email.'%']])
                ->get();
            

                $count = 0;
                foreach($usuarios as $usuario){
                    $response["data"][$count]["type"] ="user";
                    $response["data"][$count]["id"]=$usuario->id;
                    $response["data"][$count]["attributes"]["nombres"]=$usuario->nombres;
                    $response["data"][$count]["attributes"]["apellidos"] = $usuario->apellidos;
                    $response["data"][$count]["attributes"]["tipoUsuario"] = $usuario->tipoUsuario;
                    $response["data"][$count]["attributes"]["estado"] = $usuario->estado;
                    $response["data"][$count]["attributes"]["login"] = $usuario->login;
                    $count = $count + 1;
                }
             }

        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
    }

    public function showById($id) {
        try{
    
            $response = [
                'data' => []
            ];
            $statusCode = 200;
            //$usuarios = User::where([['id','=',$id]])->first();
            $usuarios = DB::table('users as u')
                ->select('u.*')
                ->where([['u.id', '=', $id]])
                ->get();
            $count = 0;
            foreach($usuarios as $usuario){
                $response["data"][$count]["type"] ="user";
                $response["data"][$count]["id"]=$usuario->id;
                $response["data"][$count]["attributes"]["nombres"]=$usuario->nombres;
                $response["data"][$count]["attributes"]["apellidos"] = $usuario->apellidos;
                $response["data"][$count]["attributes"]["tipoUsuario"] = $usuario->tipoUsuario;
                $response["data"][$count]["attributes"]["login"] = $usuario->login;
                $response["data"][$count]["attributes"]["estado"] = $usuario->estado;
                $count = $count + 1;
            }
        }catch (\Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
        //return Usuario::get();
    }
    
    public function store(Request $request) {
        
        $usuarioTmp = User::where([['email','=',$request->input("email")],['estado','=','AC']])->first();
        if($usuarioTmp!=null)
            return Response::json(array('success' => false, 'mensaje' => "El correo electronico ya fue registrado, ingrese otro correo."), 200);
        
        $password=$request->input("password");
        $passwordEncriptado=bcrypt($password);
    
        $usuario=new User();
        $usuario->email=$request->input("email");
        $usuario->nombres=$request->input("nombres");
        $usuario->apellidos=$request->input("apellidos");
        $usuario->numeroDocumento=$request->input("numeroDocumento");
        $usuario->numeroRegistro=$request->input("numeroRegistro");
        $usuario->password=$passwordEncriptado;
        $usuario->fechaCreacion=date("Y-m-d H:i:s");
        $usuario->login=$request->input("email");
        $usuario->tipoUsuario=0;
        $usuario->estado="VA";
        
        if($usuario->save()){
            
            User::where('email', $usuario->email)->where('id','<>',$usuario->id)->delete();
            
            $nombreUsuario=$usuario->nombres." ".$usuario->apellidos;
            $codigoValidacion=bcrypt($this->generateRandomString(10))."abScaD".$usuario->id;
            $url="http://www.catastrocbba.com/catastroBackend/public/catastrocbba/misc/validacion?code=$codigoValidacion&email=".$usuario->email;
            $enlaceValidacion="&nbsp;&nbsp;&nbsp;&nbsp;<a href='$url'>Enlace de validaci&oacute;n</a>";
            $phpMailer=new MyPHPMailer();
            if($phpMailer->enviarMailNotificacion( $usuario->email,"Valida tu cuenta de Catastro por favor.",
                "Tu cuenta de catastro fue creada" ,
                "Hemos creado tu cuenta de catastro pero necesitamos que validez tu correo electronico dandole click al siguiente enlace.<br>$enlaceValidacion",$nombreUsuario)){
                return Response::json(array('success' => true, 'mensaje' => "Revise y valide el correo ".$usuario->email), 200);
            }else {
                User::find($usuario->id)->delete();
                return Response::json(array('success' => false, 'mensaje' => "No se pudo enviar el correo"), 200);
            }
            
            
            return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
        }else{
            return Response::json(array('success' => false, 'mensaje' => "No se pudo crear la cuenta"), 200);
        }
        
    }
    
    public function update(Request $request) {
        $email=$request->input("email");
        $nombres=$request->input("nombres");
        $apellidos=$request->input("apellidos");
        $numeroDocumento=$request->input("numeroDocumento");
        $numeroRegistro=$request->input("numeroRegistro");
        $emailAntiguo=$request->input("emailAntiguo");
        $password=$request->input("password");
        
        $credentials=array("email"=>$emailAntiguo,"password"=>$password);
        $token = JWTAuth::attempt($credentials);
        $user = Auth::User();
        if($user==null){
            return Response::json(array('success' => false, 'mensaje' => "La contrasena es incorrecta"), 200);
        }else{
        
            $usuario=User::find($user->id);
        
            $usuario->email=$email;
            $usuario->nombres=$nombres;
            $usuario->apellidos=$apellidos;
            $usuario->numeroDocumento=$numeroDocumento;
            $usuario->numeroRegistro=$numeroRegistro;
        
            if($usuario->save()){
                return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
            }else{
                return Response::json(array('success' => false, 'mensaje' => "No se pudo actualizar los datos"), 200);
            }
        }
    }
    
    
    public function encriptarValor($pass){
        $codificado=bcrypt($pass);
        return Response::json(array($pass => $codificado), 200);
    }
    public function sincronizarUsuario(Request $request){
       
        $user = Auth::User();
        $usuario = User::where('id','=',$user->id)->first();
        
        if($usuario==null){
            return Response::json(array('success' => false, 'mensaje' => "Los datos de acceso con incorrectos","usuario"=>null), 200);
        }else{
            
            
            $listaZonaHomogenea=ZonaHomogeneaController::getListZonaHomogenea();
            $listaCoeficienteTopoGrafico=CoeficienteTopograficoController::getListCoeficientesTopografico();
            $listaUbicacionPredio=UbicacionPredioController::getListUbicacionPredio();
            $listaMaterialVia=MaterialViumController::getListMaterialVia();
            $listaFormaPredio=FormaPredioController::getListFormaPredio();
            $listaServicio=ServicioController::getListServicio();
            $listaTipologiaConstructivas=TipologiasConstructivaController::getListTipologiaConstructiva();
            $listaTipoMejoras=TipoMejoraController::getListTipoMejora();
            $listaTipologiaMejora=TipologiasMejoraController::getListTipologiaMejora();
            $listaCoeficienteUso=CoeficientesUsoController::getListCoefecienteUso();
            $listaTipoCaracteristicas=TipoCaracteristicasController::getListTipoCaracteristica();
            $listaCaracteristicasBloque=CaracteristicasBloqueController::getListCaracteristicasBloque();
            $listaCoefecienteDepreciacion=CoeficienteDepreciacionController::getListCoefecienteDepreciacion();
            
            
            $listaAvaluo=AvaluoController::getListAvaluosByIdUsuario($usuario->id);
            $listaPredio=PredioController::getListPredioByIdUsuarioAndroid($usuario->id);
            $listaImagenPredio=ImagenPredioController::getListImagenPredioByIdUsuario($usuario->id);
            $listaDatosPropietario=DatosPropietarioController::getListDatosPropietarioByIdUsuario($usuario->id);
            $listaBloquesDato=BloquesDatoController::getListBloquesDatoByIdUsuario($usuario->id);
            $listaValoresBloque=ValoresBloqueController::getListValorBloqueByIdUsuario($usuario->id);
            $listaPredioDato=PredioDatoController::getListPredioDatoByIdUsuario($usuario->id);
            $listaPredioServicio=PredioServicioController::getListPredioServicioByIdUsuario($usuario->id);
            
            
            
            
            
            return Response::json(array('success' => true, 'mensaje' => "OK",
                "usuario"=>$usuario,
                "listaZonaHomogenea"=>$listaZonaHomogenea,
                "listaCoeficienteTopoGrafico"=>$listaCoeficienteTopoGrafico,
                "listaUbicacionPredio"=>$listaUbicacionPredio,
                "listaMaterialVia"=>$listaMaterialVia,
                "listaFormaPredio"=>$listaFormaPredio,
                "listaServicio"=>$listaServicio,
                "listaTipologiaConstructivas"=>$listaTipologiaConstructivas,
                "listaTipoMejoras"=>$listaTipoMejoras,
                "listaTipologiaMejora"=>$listaTipologiaMejora,
                "listaCoeficienteUso"=>$listaCoeficienteUso,
                "listaTipoCaracteristicas"=>$listaTipoCaracteristicas,
                "listaCaracteristicasBloque"=>$listaCaracteristicasBloque,
                "listaCoeficienteDepreciacion"=>$listaCoefecienteDepreciacion,
                
                
                "listaAvaluo"=>$listaAvaluo,
                "listaPredio"=>$listaPredio,
                "listaImagenPredio"=>$listaImagenPredio,
                "listaDatosPropietario"=>$listaDatosPropietario,
                "listaBloquesDato"=>$listaBloquesDato,
                "listaValoresBloque"=>$listaValoresBloque,
                "listaPredioDato"=>$listaPredioDato,
                "listaPredioServicio"=>$listaPredioServicio,
                
            ), 200);
        }
    }
	
	
	//Agregado Ruddy


    public function migrarDatosByIdUsuarioAndIdPredio(Request $request)
    {
            //idUsuario que esta migrando los datos
            $idUsuario = $request->input('idUsuario');

            $idPredio = $request->input('idPredio');
            
            //usuario que esta migrando los datos
            $usuario = User::where('id','=',$idUsuario)->first();
            //usuario propietario del avaluo registrado que sera migrado
            $idUsuarioPredio = $this->getIdUsuarioByIdPredio($idPredio);
            $usuarioPropietario = User::where('id','=',$idUsuarioPredio)->first();

            //lista con los nombres de las imagenes a migrar
            $listaNombresImagenes = array();

            //instancias de modelos para la BD 2
            $avaluo = new Avaluo();
            $avaluo->setConnection('mysql2');

            $bloqueDato = new BloquesDato();
            $bloqueDato->setConnection('mysql2');

            $caracteristicasBloque = new CaracteristicasBloque();
            $caracteristicasBloque->setConnection('mysql2');

            $coeficienteDepreciacion = new CoeficienteDepreciacion();
            $coeficienteDepreciacion->setConnection('mysql2');

            $coeficienteTopografico = new CoeficienteTopografico();
            $coeficienteTopografico->setConnection('mysql2');

            $coeficienteUso = new CoeficienteUso();
            $coeficienteUso->setConnection('mysql2');

            $datosPropietario = new DatosPropietario();
            $datosPropietario->setConnection('mysql2');

            $formaPredio = new FormaPredio();
            $formaPredio->setConnection('mysql2');

            $imagenPredio = new ImagenPredio();
            $imagenPredio->setConnection('mysql2');

            $materialVium = new MaterialVium();
            $materialVium->setConnection('mysql2');

            $predio = new Predio();
            $predio->setConnection('mysql2');

            $predioDato = new PredioDato();
            $predioDato->setConnection('mysql2');

            $predioServicio = new PredioServicio();
            $predioServicio->setConnection('mysql2');

            $servicio = new Servicio();
            $servicio->setConnection('mysql2');

            $tipoCaracteristica = new TipoCaracteristica();
            $tipoCaracteristica->setConnection('mysql2');

            $tipologiasConstructiva = new TipologiasConstructiva();
            $tipologiasConstructiva->setConnection('mysql2');

            $tipologiasMejora = new TipologiasMejora();
            $tipologiasMejora->setConnection('mysql2');

            $tipoMejora = new TipoMejora();
            $tipoMejora->setConnection('mysql2');

            $ubicacionPredio = new UbicacionPredio();
            $ubicacionPredio->setConnection('mysql2');

            $usuario2 = new User();
            $usuario2->setConnection('mysql2');

            $valoresBloque = new ValoresBloque();
            $valoresBloque->setConnection('mysql2');

            $zonaHomogenea = new ZonaHomogenea();
            $zonaHomogenea->setConnection('mysql2');



            try {

                //datos usuario migracion
            $aUsuario = $usuario2->where('id','=',$usuario->id)->first();
            if($aUsuario == null)
            {
                $usuario2->insert($usuario->toArray());

            }
            else
            {
                $aUsuario->login = $usuario->login;
                $aUsuario->password=$usuario->password;
                $aUsuario->fechaCreacion = $usuario->fechaCreacion;
                $aUsuario->nombres = $usuario->nombres;
                $aUsuario->apellidos = $usuario->apellidos;
                $aUsuario->numeroDocumento = $usuario->numeroDocumento;
                $aUsuario->numeroRegistro = $usuario->numeroRegistro;
                $aUsuario->tipoUsuario = $usuario->tipoUsuario;
                $aUsuario->estado = $usuario->estado;
                $aUsuario->email = $usuario->email;

                $aUsuario->save();

            }

            //datos usuario propietario del registro predio
            $aUsuario2 = $usuario2->where('id','=',$idUsuarioPredio)->first();
            if($aUsuario2 == null)
            {
                if ($usuarioPropietario->tipoUsuario != 1 && $usuarioPropietario->tipoUsuario != 2) {
                    $usuarioPropietario->estado = "EL";
                }
                $usuario2->insert($usuarioPropietario->toArray());
            }
            else
            {
                $aUsuario2->login = $usuarioPropietario->login;
                $aUsuario2->password=$usuarioPropietario->password;
                $aUsuario2->fechaCreacion = $usuarioPropietario->fechaCreacion;
                $aUsuario2->nombres = $usuarioPropietario->nombres;
                $aUsuario2->apellidos = $usuarioPropietario->apellidos;
                $aUsuario2->numeroDocumento = $usuarioPropietario->numeroDocumento;
                $aUsuario2->numeroRegistro = $usuarioPropietario->numeroRegistro;
                $aUsuario2->tipoUsuario = $usuarioPropietario->tipoUsuario;
                $aUsuario2->estado = "EL";
                $aUsuario2->email = $usuarioPropietario->email;

                $aUsuario2->save();

            }

            //buscamos el avaluo del predio enviado
            $avaluoTemp = AvaluoController::getAvaluoByPrintByIdPredio($idPredio);
            $idAvaluo = $avaluoTemp->idAvaluo;
            //datos Avaluo

            $listaAvaluo=AvaluoController::getListAvaluosByIdAvaluo($idAvaluo);
            
            foreach ($listaAvaluo as $av) {                
                if ($av->estadoAvaluo == 0) {
                    

                    //guardamos el avaluo en la BD2
                    $avaluo->insert($av->toArray()); 


                    //insertamos el predio correspondiente al avaluo    
                    //datos predio
                        $listaPredio = PredioController::getListPredioByIdAvaluo($idAvaluo);

                        foreach ($listaPredio as $p) {

                            $predio->insert((array)$p);

                            

                            //insertamos la la imagen del predio

                            $listaImagenPredio = ImagenPredioController::getListImagenPredioByIdPredio($p->idPredio);
                            foreach ($listaImagenPredio as $i) {
                                $imagenPredio->insert($i->toArray());
                                $listaNombresImagenes[] = $i->imagen;
                            }

                            //insertamos datos del propietario
                            $listaDatosPropietario = DatosPropietarioController::getListDatosPropietarioByIdPredio($p->idPredio);
                            foreach ($listaDatosPropietario as $dp) {
                                $datosPropietario->insert($dp->toArray());
                            }

                            //insertamos losa datos bloque

                            $listaBloquesDato = BloquesDatoController::getListBloquesDatoByIdPredio($p->idPredio);
                            foreach ($listaBloquesDato as $bd) {
                                $bloqueDato->insert((array)$bd);

                                //insertamos valores bloque
                                $listaValoresBloque = ValoresBloqueController::getListValorBloqueByIdBloqueDato($bd->idBloqueDato);
                                foreach ($listaValoresBloque as $vb) {
                                    $valoresBloque->insert((array)$vb);
                                }
                            }

                            //insertamos predio dato

                            $listaPredioDato = PredioDatoController::getListPredioDatoByIdPredio($p->idPredio);
                            foreach ($listaPredioDato as $pd) {
                                    
                                    $predioDato->insert($pd->toArray());

                                    //insertamos predio servicio
                                    $listaPredioServicio = PredioServicioController::getListPredioServicioByIdPredioDato($pd->idPredioDato);
                                    foreach ($listaPredioServicio as $ps) {
                                        $predioServicio->insert((array)$ps);
                                    }
                                    
                            }

                            //se�al para envio de imagenes ftp
                            PredioController::migrarImagenesFtp($p->idPredio);


                        }

                } 
            }
            
             


            } catch (\Exception $e) {
                return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id_avaluo"=>null), 200);
            }

            //guardado de datos en la tabla migracion

            try {

                    $migracion = new Migracion();
                    $migracion->setConnection('mysql2');
                    $migracion->fechaMigracion = date("Y-m-d H:i:s");
                    $migracion->idUsuario = $idUsuario;
                    $migracion->idAvaluo = $idAvaluo;
                    $migracion->ipUsuario = $request->ip();
                    $migracion->datosUsuario = $request->server('HTTP_USER_AGENT');
                    $migracion->save();

                
            } catch (\Exception $e) {
                    return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id_migracion"=>null), 200);
                
            }

            //modificamos el estado del avaluo original y el avaluo2 migrado a 1 para se�alar que fue migrado
            try {

                    //avaluo original
                    $aAvaluo = Avaluo::find($idAvaluo);
                    $aAvaluo->estadoAvaluo = 1;
                    $aAvaluo->save();
                    //avaluo migrado
                    $avaluoMigrado = new Avaluo();
                    $avaluoMigrado->setConnection('mysql2');
                    $avaluoMigrado= $avaluoMigrado->find($idAvaluo); 
                    $avaluoMigrado->estadoAvaluo = 1;
                    $avaluoMigrado->save();
                
            } catch (\Exception $e) {
                return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString(),"last_insert_id_avaluo"=>null), 200);
            }

            return Response::json(array('success' => true, 'mensaje' => "OK","last_insert_id_avaluo"=>$idAvaluo,'listaImagenes'=> $listaNombresImagenes), 200);
    }

    public function migrarDatosByIdUsuarioAndIdPredioFtp(Request $request)
    {
        //idUsuario que esta migrando los datos
            $idUsuario = $request->input('idUsuario');

            $idPredio = $request->input('idPredio');
            
            //usuario que esta migrando los datos
            $usuario = User::where('id','=',$idUsuario)->first();
            //usuario propietario del avaluo registrado que sera migrado
            $idUsuarioPredio = $this->getIdUsuarioByIdPredio($idPredio);
            $usuarioPropietario = User::where('id','=',$idUsuarioPredio)->first();

            //lista con los nombres de las imagenes a migrar
            $listaNombresImagenes = array();

            //instancias de modelos para la BD 2
            $avaluo = new Avaluo();
            $avaluo->setConnection('mysql2');

            $bloqueDato = new BloquesDato();
            $bloqueDato->setConnection('mysql2');

            $datosPropietario = new DatosPropietario();
            $datosPropietario->setConnection('mysql2');

            $imagenPredio = new ImagenPredio();
            $imagenPredio->setConnection('mysql2');

            $predio = new Predio();
            $predio->setConnection('mysql2');

            $predioDato = new PredioDato();
            $predioDato->setConnection('mysql2');

            $predioServicio = new PredioServicio();
            $predioServicio->setConnection('mysql2');

            $usuario2 = new User();
            $usuario2->setConnection('mysql2');

            $valoresBloque = new ValoresBloque();
            $valoresBloque->setConnection('mysql2');

            //DB::disconnect();
            DB::connection("mysql")->beginTransaction();
            DB::connection("mysql2")->beginTransaction();

                try {
                    



                    //datos usuario migracion
                    $aUsuario = $usuario2->where('id','=',$usuario->id)->first();
                    if($aUsuario == null)
                    {
                        //$usuario2->insert($usuario->toArray());
                        DB::connection("mysql2")->table('users')->insert($usuario->toArray());

                    }
                    else
                    {
                        $aUsuario->login = $usuario->login;
                        $aUsuario->password=$usuario->password;
                        $aUsuario->fechaCreacion = $usuario->fechaCreacion;
                        $aUsuario->nombres = $usuario->nombres;
                        $aUsuario->apellidos = $usuario->apellidos;
                        $aUsuario->numeroDocumento = $usuario->numeroDocumento;
                        $aUsuario->numeroRegistro = $usuario->numeroRegistro;
                        $aUsuario->tipoUsuario = $usuario->tipoUsuario;
                        $aUsuario->estado = $usuario->estado;
                        $aUsuario->email = $usuario->email;

                        $aUsuario->save();

                    }

                    //datos usuario propietario del registro predio
                    $aUsuario2 = $usuario2->where('id','=',$idUsuarioPredio)->first();
                    if($aUsuario2 == null)
                    {
                        if ($usuarioPropietario->tipoUsuario != 1 && $usuarioPropietario->tipoUsuario != 2) {
                            $usuarioPropietario->estado = "EL";
                        }
                        //PredioController::migrarImagenesFtp($idPredio);
                        DB::connection("mysql2")->table('users')->insert($usuarioPropietario->toArray());
                    }
                    else
                    {
                        $aUsuario2->login = $usuarioPropietario->login;
                        $aUsuario2->password=$usuarioPropietario->password;
                        $aUsuario2->fechaCreacion = $usuarioPropietario->fechaCreacion;
                        $aUsuario2->nombres = $usuarioPropietario->nombres;
                        $aUsuario2->apellidos = $usuarioPropietario->apellidos;
                        $aUsuario2->numeroDocumento = $usuarioPropietario->numeroDocumento;
                        $aUsuario2->numeroRegistro = $usuarioPropietario->numeroRegistro;
                        $aUsuario2->tipoUsuario = $usuarioPropietario->tipoUsuario;

                        if ($usuarioPropietario->tipoUsuario == 0) {
                            $aUsuario2->estado = "EL";
                        }
                        else
                        {
                            $aUsuario2->estado = "AC";
                        }

                        
                        $aUsuario2->email = $usuarioPropietario->email;

                        //PredioController::migrarImagenesFtp($idPredio);

                        $aUsuario2->save();

                    }


                    //buscamos el avaluo del predio enviado
                    $avaluoTemp = AvaluoController::getAvaluoByPrintByIdPredio($idPredio);
                    $idAvaluo = $avaluoTemp->idAvaluo;
                    //datos Avaluo

                    $listaAvaluo=AvaluoController::getListAvaluosByIdAvaluo($idAvaluo);
                    
                    foreach ($listaAvaluo as $av) {                
                        if ($av->estadoAvaluo == 0) {
                            

                            //guardamos el avaluo en la BD2
                            DB::connection("mysql2")->table('avaluo')->insert($av->toArray()); 


                            //insertamos el predio correspondiente al avaluo    
                            //datos predio
                                $listaPredio = PredioController::getListPredioByIdAvaluo($idAvaluo);

                                foreach ($listaPredio as $p) {

                                    
                                    DB::connection("mysql2")->table('predio')->insert((array)$p);
                                    

                                    //insertamos las imagenes del predio

                                    $listaImagenPredio = ImagenPredioController::getListImagenPredioByIdPredio($p->idPredio);
                                    foreach ($listaImagenPredio as $i) {
                                        //$imagenPredio->insert($i->toArray());
                                        //$listaNombresImagenes[] = $i->imagen;
                                        DB::connection("mysql2")->table('imagen_predio')->insert($i->toArray());
                                    }


                                    //insertamos datos del propietario
                                    $listaDatosPropietario = DatosPropietarioController::getListDatosPropietarioByIdPredio($p->idPredio);
                                    foreach ($listaDatosPropietario as $dp) {
                                        //$datosPropietario->insert($dp->toArray());
                                        DB::connection("mysql2")->table('datos_propietario')->insert($dp->toArray());
                                    }

                                    //insertamos los datos bloque

                                    $listaBloquesDato = BloquesDatoController::getListBloquesDatoByIdPredio($p->idPredio);
                                    foreach ($listaBloquesDato as $bd) {
                                        //$bloqueDato->insert((array)$bd);
                                        DB::connection("mysql2")->table('bloques_dato')->insert((array)$bd);

                                        //insertamos valores bloque
                                        $listaValoresBloque = ValoresBloqueController::getListValorBloqueByIdBloqueDato($bd->idBloqueDato);
                                        foreach ($listaValoresBloque as $vb) {
                                            //$valoresBloque->insert((array)$vb);
                                            DB::connection("mysql2")->table('valores_bloque')->insert((array)$vb);
                                        }
                                    }

                                    //insertamos predio dato

                                    $listaPredioDato = PredioDatoController::getListPredioDatoByIdPredio($p->idPredio);
                                    foreach ($listaPredioDato as $pd) {
                                            
                                            //$predioDato->insert($pd->toArray());
                                            DB::connection("mysql2")->table('predio_dato')->insert($pd->toArray());

                                            //insertamos predio servicio
                                            $listaPredioServicio = PredioServicioController::getListPredioServicioByIdPredioDato($pd->idPredioDato);
                                            foreach ($listaPredioServicio as $ps) {
                                                //$predioServicio->insert((array)$ps);
                                                DB::connection("mysql2")->table('predio_servicio')->insert((array)$ps);
                                            }
                                            
                                    }

                                    //se�al para envio de imagenes ftp si es falso todo se cancela
                                    if (!PredioController::migrarImagenesFtp($p->idPredio)) {
                                        DB::connection("mysql2")->rollBack();
                                        DB::connection("mysql")->rollBack();
                                        return Response::json(array('success' => false, 'mensaje' => "Error ftp"), 200);
                                    }
                                    


                                }

                        } 
                    }


                    //guardado de datos de la migracion
                    $migracion = new Migracion();
                    $migracion->setConnection('mysql2');
                    $migracion->fechaMigracion = date("Y-m-d H:i:s");
                    $migracion->idUsuario = $idUsuario;
                    $migracion->idAvaluo = $idAvaluo;
                    $migracion->ipUsuario = $request->ip();
                    $migracion->datosUsuario = $request->server('HTTP_USER_AGENT');
                    $migracion->save();


                    //modificamos el estado del avaluo original y el avaluo2 migrado a 1 para se�alar que fue migrado
                    //avaluo original
                    $aAvaluo = Avaluo::find($idAvaluo);
                    $aAvaluo->estadoAvaluo = 1;
                    $aAvaluo->save();
                    //avaluo migrado
                    $avaluoMigrado = new Avaluo();
                    $avaluoMigrado->setConnection('mysql2');
                    $avaluoMigrado= $avaluoMigrado->find($idAvaluo); 
                    $avaluoMigrado->estadoAvaluo = 1;

                    //PredioController::migrarImagenesFtp($idPredio);

                    $avaluoMigrado->save();



                    DB::connection("mysql2")->commit();
                    DB::connection("mysql")->commit();
                } catch (\Exception $e) {
                    DB::connection("mysql2")->rollBack();
                    DB::connection("mysql")->rollBack();
                    return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
                }
                
            return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
	
    public function resetPassword(Request $request){
        $email=$request->input("email");
        
        $usuario=User::where("email","=",$email)->first();
        
        if($usuario!=null){
            $nuevaContrasena=$this->generateRandomString(8);
            $nuevaContrasenaEncriptada=bcrypt($nuevaContrasena);
            
            $usuario->password=$nuevaContrasenaEncriptada;
            if(!$usuario->save()){
                return Response::json(array('success' => false, 'mensaje' => "No se pudo actualizar la contrasena, intentelo otra vez."), 200);
            }
            
            $nombreUsuario=$usuario->nombres." ".$usuario->apellidos;
            
            $phpMailer=new MyPHPMailer();
            if($phpMailer->enviarMailNotificacion( $email,"Reinicio de contrasena",
                "Hemos reiniciado tu contrase&ntilde;a" ,"Tu contrase&ntilde;a fue
                reiniciada como tu lo solicitaste, la nueva contrase&ntilde;a es <br>
                <br>$nuevaContrasena<br><br>No te olvidez cambiar tu contrase&ntilde;a para la recuerdes mas facilmente.",$nombreUsuario)){
                return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
            }else return Response::json(array('success' => false, 'mensaje' => "No se pudo enviar el correo"), 200);
        }else{
            return Response::json(array('success' => false, 'mensaje' => "El correo ingresado no existe"), 200);
        }
        
       
        

    }
    public function cambiarPassword(Request $request){
        $email=$request->input("email");
        $passwordActual=$request->input("passwordActual");
        $passwordNuevo=$request->input("passwordNuevo");
        
        
        $credentials=array("email"=>$email,"password"=>$passwordActual);
        $token = JWTAuth::attempt($credentials);
        $user = Auth::User();
        
        
        
        if($user==null){
            return Response::json(array('success' => false, 'mensaje' => "La contrasena actual es incorrecta"), 200);
        }else{
            $nuevaContrasenaEncriptada=bcrypt($passwordNuevo);
            $usuario=User::find($user->id);
            $usuario->password=$nuevaContrasenaEncriptada;
            if($usuario->save()){
                return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
            }else{
                return Response::json(array('success' => false, 'mensaje' => "No se pudo guardar la nueva contrasena"), 200);
            }
        }
    }
    public function validacionCuenta(){
        
        if(isset($_GET["code"]) && isset($_GET["email"])){
            $code=$_GET["code"];
            $email=$_GET["email"];
            if(strlen($code)>0){
                $partes=explode("abScaD", $code);
                if(isset($partes[1])){
                    $idUsuario=$partes[1];
                    $usuario=User::find($idUsuario);
                    if($usuario!=null){
                        if($usuario->email==$email){
                            $usuario->estado="AC";
                            if($usuario->save())
							{
                                //return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
								$titulo="Cuenta validada";
                                $mensaje = "Para el usuario: ".$email;
                                $error = false;
								return Response::view('validacion',compact('titulo','mensaje','error'));
							}
                            else
							{
                                $titulo="Ocurrio un error";
                                $mensaje = "No se puedo activar la cuenta.";
                                $error = true;
								return Response::view('validacion',compact('titulo','mensaje','error'));
								//return Response::json(array('success' => false, 'mensaje' => "No se pudo activar la cuenta."), 200);
							}
                        }    
                    }
                    
                }
                
            }
        }
        return Response::json(array('success' => false, 'mensaje' => "El enlace de validacion es invalido"), 200);
        
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //agregado Ruddy
    public function cambiarTipoUsuario(Request $request)
    {
        $input = $request->all();
        try {
            User::where('id',$input['id'])->update($input);
        } catch (\Exception $e) {
            return Response::json(array('success' => false, "ingreso"=>$input,'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
        }
        return Response::json(array('success' => true, 'mensaje' => "OK"), 200);

    }
	
	//agregado Ruddy
    public function getIdUsuarioByIdPredio($idPredio)
    {
        $idUsuario = DB::table('predio as p')
        ->join('avaluo as a','a.idAvaluo','=','p.idAvaluo')
        ->join('users as u','u.id','=','a.idUsuario')
        ->select('u.*')
        ->where('p.idPredio','=',$idPredio)
        ->first();
        return $idUsuario->id;

    }

    public function migrarUsuario(Request $request)
    {
        //idUsuario que esta migrando los datos
            $idUsuario = $request->input('idUsuarioMigrador');

            $idUsuarioDos = $request->input('idUsuarioAMigrar');
            
            //usuario que esta migrando los datos
            $usuario = User::where('id','=',$idUsuario)->first();
            //usuario a migrar
            $usuarioMigrar = User::where('id','=',$idUsuarioDos)->first();


            //instancias de modelos para la BD 2
            

            $usuario2 = new User();
            $usuario2->setConnection('mysql2');

    
            //DB::disconnect();
            DB::connection("mysql")->beginTransaction();
            DB::connection("mysql2")->beginTransaction();

                try {
                    



                    //datos usuario que hace la migracion
                    $aUsuario = $usuario2->where('id','=',$usuario->id)->first();
                    if($aUsuario == null)
                    {
                        //$usuario2->insert($usuario->toArray());
                        DB::connection("mysql2")->table('users')->insert($usuario->toArray());

                    }
                    else
                    {
                        $aUsuario->login = $usuario->login;
                        $aUsuario->password=$usuario->password;
                        $aUsuario->fechaCreacion = $usuario->fechaCreacion;
                        $aUsuario->nombres = $usuario->nombres;
                        $aUsuario->apellidos = $usuario->apellidos;
                        $aUsuario->numeroDocumento = $usuario->numeroDocumento;
                        $aUsuario->numeroRegistro = $usuario->numeroRegistro;
                        $aUsuario->tipoUsuario = $usuario->tipoUsuario;
                        $aUsuario->estado = $usuario->estado;
                        $aUsuario->email = $usuario->email;

                        $aUsuario->save();

                    }

                    //datos usuario a migrar
                    $aUsuario2 = $usuario2->where('id','=',$idUsuarioDos)->first();
                    if($aUsuario2 == null)
                    {
                        
                        DB::connection("mysql2")->table('users')->insert($usuarioMigrar->toArray());
                    }
                    else
                    {
                        $aUsuario2->login = $usuarioMigrar->login;
                        $aUsuario2->password=$usuarioMigrar->password;
                        $aUsuario2->fechaCreacion = $usuarioMigrar->fechaCreacion;
                        $aUsuario2->nombres = $usuarioMigrar->nombres;
                        $aUsuario2->apellidos = $usuarioMigrar->apellidos;
                        $aUsuario2->numeroDocumento = $usuarioMigrar->numeroDocumento;
                        $aUsuario2->numeroRegistro = $usuarioMigrar->numeroRegistro;
                        $aUsuario2->tipoUsuario = $usuarioMigrar->tipoUsuario;

                        $aUsuario2->estado = "AC";

                        $aUsuario2->email = $usuarioMigrar->email;


                        $aUsuario2->save();

                    }


                    


                    //guardado de datos de la migracion
                    $migracion = new Migracion();
                    $migracion->setConnection('mysql2');
                    $migracion->fechaMigracion = date("Y-m-d H:i:s");
                    $migracion->idUsuario = $idUsuario;
                    //$migracion->idAvaluo = ;
                    $migracion->ipUsuario = $request->ip();
                    $migracion->datosUsuario = $request->server('HTTP_USER_AGENT');
                    $migracion->save();


                    

                    DB::connection("mysql2")->commit();
                    DB::connection("mysql")->commit();
                } catch (\Exception $e) {
                    DB::connection("mysql2")->rollBack();
                    DB::connection("mysql")->rollBack();
                    return Response::json(array('success' => false, 'mensaje' => "Exception","stackTrace"=>$e->__toString()), 200);
                }
                
            return Response::json(array('success' => true, 'mensaje' => "OK"), 200);
    }
    
}
