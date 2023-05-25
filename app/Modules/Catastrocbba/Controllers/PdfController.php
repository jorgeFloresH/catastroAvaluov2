<?php

namespace App\Modules\Catastrocbba\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Modules\Catastrocbba\Models\User;
use App\Modules\Catastrocbba\Models\Predio;
use App\Modules\Catastrocbba\Models\PredioDato;
use App\Modules\Catastrocbba\Models\PredioServicio;
use App\Modules\Catastrocbba\Controllers\DatosPropietarioController;
use App\Modules\Catastrocbba\Controllers\PredioDatoController;
use App\Modules\Catastrocbba\Models\ZonaHomogenea;
use App\Modules\Catastrocbba\Models\CoeficienteTopografico;
use App\Modules\Catastrocbba\Models\FormaPredio;
use App\Modules\Catastrocbba\Models\MaterialVium;
use App\Modules\Catastrocbba\Models\UbicacionPredio;
use Barryvdh\DomPDF\PDF;
use App\Modules\Catastrocbba\Models\ImagenPredio;
use App\Modules\Catastrocbba\Models\TipologiasConstructiva;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class PdfController extends Controller
{
    public function reporteFormularioActualizacionDatosTecnicos($idPredio,$idUser,$email)
    {
        $cuentaValida=FALSE;
        
        $user=User::where([['email','=',$email],['id','=',$idUser]])->first();
        if($user!=null){
            $cuentaValida=TRUE;
            //$user = User::find($idUser);
            $idUsuario=$user->id;
            
            $zonaHomogeneaString="No disponible";
            $coeficienteTopograficoString="No disponible";
            $ubicacionPredioString="No disponible";
            $materialViaString="No disponible";
            $formaPredioString="No disponible";
            
            $frenteString="No disponible";
            $fondoString="No disponible";
            $superficieAprobadaString="No disponible";
            $observacionesString="No se realizaron observaciones";
            
            $informacionLegalUno="Matricula: No registra";
            $informacionLegalDos="Asiento: No registra";
            $informacionLegalFecha="Fecha DDRR: No registra";
            
            $predio=Predio::find($idPredio);
            
            $sd=substr($predio->codigoCatastral, 0,2);
            $mmm=substr($predio->codigoCatastral, 2,3);
            $ppp=substr($predio->codigoCatastral, 5,3);
            $u=substr($predio->codigoCatastral, 8,1);
            $bl=substr($predio->codigoCatastral, 9,2);
            $pla=substr($predio->codigoCatastral, 11,3);
            $uni=substr($predio->codigoCatastral, 14,3);
            
            $codigoCatastral=$sd."-".$mmm."-".$ppp."-".$u."-".$bl."-".$pla."-".$uni;
            $predio->codigoCatastral=$codigoCatastral;
            
            $predioDato=PredioDatoController::getPredioDatoByIdPredio($idPredio);
            if($predioDato!=null){
                $zonaHomogenea=ZonaHomogenea::find($predioDato->idZonaHomogenea);
                $coeficienteTopografico=CoeficienteTopografico::find($predioDato->idCoeficienteTopografico);
                $ubicacionPredio=UbicacionPredio::find($predioDato->idUbicacionPredio);
                $materialVia=MaterialVium::find($predioDato->idMaterialVia);
                $formaPredio=FormaPredio::find($predioDato->idFormaPredio);
            
                $zonaHomogeneaString=$zonaHomogenea->descripcion;
                $coeficienteTopograficoString=$coeficienteTopografico->descripcion;
                $ubicacionPredioString=$ubicacionPredio->descripcion;
                $materialViaString=$materialVia->descripcion;
                $formaPredioString=$formaPredio->descripcion;
            
                $frenteString=$predioDato->frentePredio;
                $fondoString=$predioDato->fondoPredio;
                $superficieAprobadaString=$predioDato->superficieAprobada;
            
                $observacionesString=$predioDato->observaciones;
            
            }
            
            
            $ciudadesCI=array(0=>"Cochabamba",1=>"Santa Cruz",2=>"La Paz",3=>"Oruro",4=>"Potosi",5=>"Tarija",6=>"Chuquisaca",7=>"Beni",8=>"Pando",9=>"Extranjero",10=>"Otros");
            
            $propietarioString="";
            $propietarioCIString="";
            $listaPropietarios=DatosPropietarioController::getListDatosPropietarioByIdPredio($idPredio);
          //  $propietarioString=count($listaPropietarios);
            foreach ($listaPropietarios as $propietario){
               
                
                
               $propietarioString.=$propietario->nombres." ".$propietario->apellidoUno." ".$propietario->apellidoDos;
               if($propietario->numeroDocumento)
                    $propietarioCIString.="CI:".$propietario->numeroDocumento." ".$ciudadesCI[$propietario->idEmitidoEn];
               if(isset($propietario->matricula) && isset($propietario->asiento)){
                    if(strlen($propietario->matricula)>0 && strlen($propietario->asiento)>0){
                        $informacionLegalUno="Matricula: ".$propietario->matricula;
                        $informacionLegalDos="Asiento: ".$propietario->asiento;
                    }else{
                        if($propietario->fojas && $propietario->partida){
                            $informacionLegalUno="Fojas: ".$propietario->fojas;
                            $informacionLegalDos="Partida: ".$propietario->partida;
                        }
                    }
               }else{
                   if(isset($propietario->fojas) && isset($propietario->partida)){
                       $informacionLegalUno="Fojas: ".$propietario->fojas;
                       $informacionLegalDos="Partida: ".$propietario->partida;
                   }
               }
                if(isset($propietario->fechaRegistroDDRR)){
                    $fechasTmp=explode("-", $propietario->fechaRegistroDDRR);
                    $diaTmp=explode(" ", $fechasTmp[2]);
                    if($fechasTmp[0]!="0000")
                        $informacionLegalFecha="Fecha DDRR:".$diaTmp[0]."/".$fechasTmp[1]."/".$fechasTmp[0];
                }
                
                break;
            }
            
            $imagenPredioController=new ImagenPredioController();
            $urlCroquis=$imagenPredioController->getURLCroquisByIdPredio($idPredio);
            $urlUbicacion=$imagenPredioController->getURLUbicacionByIdPredio($idPredio);
            $urlFachadaUno=$imagenPredioController->getURLFachadaUnoByIdPredio($idPredio);
            $urlFachadaDos=$imagenPredioController->getURLFachadaDosByIdPredio($idPredio);
            
            $servicioController=new ServicioController();
            $listaServicios=$servicioController->getListServiciosByIdPredio($idPredio);
            
            $listaTipologias=array();
            $listaSumaPuntajeBloqueDato=array();
            $bloquesDato=new BloquesDatoController();
            $listaBloqueDatosBloque=$bloquesDato->getBloques($idPredio);
            foreach ($listaBloqueDatosBloque as $bloqueDato){
                $puntaje=ValoresBloqueController::getSumaPuntajeByIdBloqueDato($bloqueDato->idBloqueDato);
                $listaSumaPuntajeBloqueDato[$bloqueDato->idBloqueDato]=$puntaje;
                $topologiaConstructiva=TipologiasConstructivaController::getTipologiaByPuntaje($puntaje);
                $listaTipologias[$bloqueDato->idBloqueDato]=$topologiaConstructiva->descripcion;
            }
            $listaBloqueDatosMejora=$bloquesDato->getMejoras($idPredio);
            foreach ($listaBloqueDatosMejora as $bloqueDato){
                $puntaje=ValoresBloqueController::getSumaPuntajeByIdBloqueDato($bloqueDato->idBloqueDato);
                $listaSumaPuntajeBloqueDato[$bloqueDato->idBloqueDato]=$puntaje;
                $topologiaConstructiva=TipologiasConstructivaController::getTipologiaByPuntaje($puntaje);
                $listaTipologias[$bloqueDato->idBloqueDato]=$topologiaConstructiva->descripcion;
            }
            
            
            $avaluo=AvaluoController::getAvaluoActualizadoByPrintByIdPredio($idPredio);
            
            $fechaImpresionTMP = explode("-", $avaluo->fechaImpresion);
            $fechaImpresion=explode(" ",$fechaImpresionTMP[2])[0]."/".$fechaImpresionTMP[1]."/".$fechaImpresionTMP[0];
            $nroFormulario = $avaluo->numeroFormulario;
            
            $codigoImpresion="I".$idPredio."F".$nroFormulario;
            
            $profesional=$user->nombres." ".$user->apellidos;
            $nroRegistroProfesional=$user->numeroRegistro;
            
            $urlQR=$this->generarQRCode($avaluo->numeroFormulario,$fechaImpresion,$profesional);
            
            $view =  \View::make('pdf.invoice', compact(
                'cuentaValida',
                'user',
                'profesional',
                'nroRegistroProfesional',
                'nroFormulario',
                'predio',
                'predioDato',
                'zonaHomogeneaString',
                'coeficienteTopograficoString',
                'ubicacionPredioString',
                'materialViaString',
                'formaPredioString',
                'frenteString',
                'fondoString',
                'superficieAprobadaString',
                'observacionesString',
                'informacionLegalUno',
                'informacionLegalDos',
                'informacionLegalFecha',
                'propietarioString',
                'propietarioCIString',
                'urlCroquis',
                'urlUbicacion',
                'urlFachadaUno',
                'urlFachadaDos',
                'listaServicios',
                'listaBloqueDatosBloque',
                'listaBloqueDatosMejora',
                'listaSumaPuntajeBloqueDato',
                'listaTipologias',
                'fechaImpresion',
                'codigoImpresion',
                'urlQR'
            ))->render();
                
        }else{
            $view =  \View::make('pdf.invoice', compact(
                'cuentaValida'
            ))->render();
        }
        
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper('A4','portrait');
        
        $orientation = 'landscape';
        $customPaper = array(0,0,810,600);
        $pdf->setPaper($customPaper, $orientation);
        
        return $pdf->stream('invoice'); 
    }
    public function reporteFormularioCaracteristicas($idPredio,$idUser,$email){
        $cuentaValida=FALSE;
        
        $user=User::where([['email','=',$email],['id','=',$idUser]])->first();
        if($user!=null){
            $cuentaValida=TRUE;
            $idUsuario=$user->id;
            
            
            $predio=Predio::find($idPredio);
            $matrizData=$this->getMatriz($idPredio);
            $matriz=$matrizData["matriz"];
            $observacionesGenerales=$matrizData["observacionesGenerales"];
            
        
            $view =  \View::make('pdf.caracteristicas', compact(
                'cuentaValida',
                'predio',
                'matriz'
            ))->render();
        
        }else{
            $view =  \View::make('pdf.caracteristicas', compact(
                'cuentaValida'
            ))->render();
        }
        
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper('A4','portrait');
        
        $orientation = 'landscape';
        $customPaper = array(0,0,810,600);
        $pdf->setPaper($customPaper, $orientation);
        
        return $pdf->stream('invoice');
    }
    private function getMatriz($idPredio){
        
        $bloqueDatoController=new BloquesDatoController();
        $listaValorBloque=array();
        $listValorBloqueTmp=ValoresBloqueController::getListValorBloqueByIdPredio($idPredio);
        foreach ($listValorBloqueTmp as $valorBloqueTmp){
            $listaValorBloque[$valorBloqueTmp->idBloqueDato][$valorBloqueTmp->idCaracteristicaBloque]=$valorBloqueTmp;
        }
        
        $observacionesGenerales="";
        $esPrimeroObservaciones=TRUE;
        
        $listaBloques=$bloqueDatoController->getBloques($idPredio);
        $listaMejoras=$bloqueDatoController->getMejoras($idPredio);
        $listaColumnas=array();
        foreach ($listaBloques as $bloqueDato){
            $listaColumnas[$bloqueDato->idBloqueDato]=$bloqueDato->numerobloque;
            if($esPrimeroObservaciones){
                $esPrimeroObservaciones=FALSE;
                if ( (strlen(trim($bloqueDato->observaciones))) > 0) {
                    $observacionesGenerales.=$bloqueDato->numerobloque.":".$bloqueDato->observaciones;
                }
				else
				{
					$esPrimeroObservaciones=TRUE;
				}
                /**$observacionesGenerales.=$bloqueDato->numerobloque.":".(strlen(trim($bloqueDato->observaciones))>0?$bloqueDato->observaciones:"No se realizo comentarios");**/
            }else
            {
                if ( (strlen(trim($bloqueDato->observaciones))) > 0) {
                    $observacionesGenerales.="; ".$bloqueDato->numerobloque.":".$bloqueDato->observaciones;
                }
                /**$observacionesGenerales.="; ".$bloqueDato->numerobloque.":".(strlen(trim($bloqueDato->observaciones))>0?$bloqueDato->observaciones:"No se realizo comentarios");**/
            } 
        }
        foreach ($listaMejoras as $bloqueDato){
            $listaColumnas[$bloqueDato->idBloqueDato]=$bloqueDato->tipoMejora;
            if($esPrimeroObservaciones){
                $esPrimeroObservaciones=FALSE;
                if ( (strlen(trim($bloqueDato->observaciones))) > 0) {
                    $observacionesGenerales.=$bloqueDato->tipoMejora.":".$bloqueDato->observaciones;
                }
				else
				{
					$esPrimeroObservaciones=TRUE;
				}
                /**$observacionesGenerales.=$bloqueDato->tipoMejora.":".(strlen(trim($bloqueDato->observaciones))>0?$bloqueDato->observaciones:"No se realizo comentarios");**/
            }else
            {
                if ( (strlen(trim($bloqueDato->observaciones))) > 0) {
                    $observacionesGenerales.="; ".$bloqueDato->tipoMejora.":".$bloqueDato->observaciones;
                }
                /**$observacionesGenerales.="; ".$bloqueDato->tipoMejora.":".(strlen(trim($bloqueDato->observaciones))>0?$bloqueDato->observaciones:"No se realizo comentarios");**/
            } 
        }
        
        
        
        $listaTipoCaracteristicaArray=array();
        $listaTipoCaracteristica=TipoCaracteristicasController::getListTipoCaracteristica();
        foreach($listaTipoCaracteristica as $tipoCaracteristica){
            $listaTipoCaracteristica[$tipoCaracteristica->idTipoCaracteristica]=$tipoCaracteristica;
        
            $listaCaracteristicaBloque=CaracteristicasBloqueController::getListCaracteristicasBloqueByIdTipoCaracteristica($tipoCaracteristica->idTipoCaracteristica);
        
            $listaTipoCaracteristicaArray[$tipoCaracteristica->idTipoCaracteristica]["tipoCaracteristica"]=$tipoCaracteristica;
            $listaTipoCaracteristicaArray[$tipoCaracteristica->idTipoCaracteristica]["listaCaracteristicaBloque"]=$listaCaracteristicaBloque;
        
        }
        
        
        
        $fila=0;
        $matriz=array();
        $listaResultados=array();
        $listaResultados["col1"]="TOTAL";
        $listaResultados["col2"]="";
        
        $matriz[$fila]["col1"]="Caracteristica";
        $matriz[$fila]["col2"]="ptj";
        $contCol=3;
        foreach ($listaColumnas as $bloqueDatoParcial){
        
            $matriz[$fila]["col$contCol"]=$bloqueDatoParcial;
            $contCol++;
        }
        $fila++;
        
        foreach ($listaTipoCaracteristicaArray as $tipoCaracteristicaElement){
            $tipoCaracteristica=$tipoCaracteristicaElement["tipoCaracteristica"];
            $listaCaracteristicaBloque=$tipoCaracteristicaElement["listaCaracteristicaBloque"];
        
            $matriz[$fila]["col1"]=$tipoCaracteristica->descripcion;
            $matriz[$fila]["col2"]="";
            $contCol=3;
            foreach ($listaColumnas as $bloqueDatoParcial){
        
                $matriz[$fila]["col$contCol"]="";
                $contCol++;
            }
            $fila++;
        
            $sumaBloqueValidador=0;
            foreach ($listaCaracteristicaBloque as $caracteristicaBloque){
                $listaValoresFila=array();
                $listaValoresFila["col1"]=$caracteristicaBloque->descripcion;
                $listaValoresFila["col2"]=$caracteristicaBloque->puntaje;
        
                $sumaFilaValidador=0;
                $contCol=3;
                foreach ($listaColumnas as $idBloqueDato=>$bloqueDatoValor){
                    $porcentaje=0;
                    if(isset($listaValorBloque[$idBloqueDato][$caracteristicaBloque->idCaracteristicaBloque])){
                        $valorBloque=$listaValorBloque[$idBloqueDato][$caracteristicaBloque->idCaracteristicaBloque];
                        $porcentaje=$valorBloque->porcentaje;
                        //$listaValoresFila["col$contCol"]=$porcentaje;
                        $sumaFilaValidador+=$porcentaje;
                    }
                    $listaValoresFila["col$contCol"]=$porcentaje;
        
                    if(!isset($listaResultados["col$contCol"]))
                        $listaResultados["col$contCol"]=0;
                    $listaResultados["col$contCol"]+=round($caracteristicaBloque->puntaje*$porcentaje/100,2);
        
                    $contCol++;
                }
                if($sumaFilaValidador>0){
                    $matriz[$fila]=$listaValoresFila;
                    $sumaBloqueValidador+=$sumaFilaValidador;
                }
        
                $fila++;
            }
        
        }
        
        $matriz[$fila]=$listaResultados;
        
        $resultado=array("matriz"=>$matriz,"observacionesGenerales"=>$observacionesGenerales);
        return $resultado;
    }
    
    public function reporteFormularioGral($idPredio,$idUser,$email)
    {
        $cuentaValida=FALSE;
        $errorOcurrido = 0;
    
        $user=User::where([['id','=',$idUser]])->first();
        $tipoUsuario = $user->tipoUsuario;
        //se cambia el usuario actual por el usuario que registro el avaluo de lo contrario al imprimir se coloca el usuario que solicito imprimir y no el que registro el avaluo
        $user = DB::table('predio as p')
            ->join('avaluo as a', 'a.idAvaluo', '=', 'p.idAvaluo')
            ->join('users as u','u.id','=','a.idUsuario')
            ->select('u.*')
            ->where([
                ['p.idPredio', '=', $idPredio],
                ])
            ->first();
        if($user!=null){
            $cuentaValida=TRUE;
            //$user = User::find($idUser);
            $idUsuario=$user->id;
    
            $zonaHomogeneaString="No disponible";
            $coeficienteTopograficoString="No disponible";
            $ubicacionPredioString="No disponible";
            $materialViaString="No disponible";
            $formaPredioString="No disponible";
    
            $frenteString="No disponible";
            $fondoString="No disponible";
            $superficieAprobadaString="No disponible";
            $observacionesString="No se realizaron observaciones";
    
            $informacionLegalUno="Matricula: No registra";
            $informacionLegalDos="Asiento: No registra";
            $informacionLegalFecha="Fecha DDRR: No registra";
    
            $predio=Predio::find($idPredio);
            
            $sd=substr($predio->codigoCatastral, 0,2);
            $mmm=substr($predio->codigoCatastral, 2,3);
            $ppp=substr($predio->codigoCatastral, 5,3);
            $u=substr($predio->codigoCatastral, 8,1);
            $bl=substr($predio->codigoCatastral, 9,2);
            $pla=substr($predio->codigoCatastral, 11,3);
            $uni=substr($predio->codigoCatastral, 14,3);
            
            $codigoCatastral=$sd."-".$mmm."-".$ppp."-".$u."-".$bl."-".$pla."-".$uni;
            
            $predio->codigoCatastral=$codigoCatastral;

            //agregado Ruddy control de exception datos propietario y bloques
            try {


                $predioDato=PredioDatoController::getPredioDatoByIdPredio($idPredio);
            if($predioDato!=null){
                $zonaHomogenea=ZonaHomogenea::find($predioDato->idZonaHomogenea);
                $coeficienteTopografico=CoeficienteTopografico::find($predioDato->idCoeficienteTopografico);
                $ubicacionPredio=UbicacionPredio::find($predioDato->idUbicacionPredio);
                $materialVia=MaterialVium::find($predioDato->idMaterialVia);
                $formaPredio=FormaPredio::find($predioDato->idFormaPredio);
    
                $zonaHomogeneaString=$zonaHomogenea->descripcion;
                $coeficienteTopograficoString=$coeficienteTopografico->descripcion;
                $ubicacionPredioString=$ubicacionPredio->descripcion;
                $materialViaString=$materialVia->descripcion;
                $formaPredioString=$formaPredio->descripcion;
    
                $frenteString=$predioDato->frentePredio;
                $fondoString=$predioDato->fondoPredio;
                $superficieAprobadaString=$predioDato->superficieAprobada;
    
                $observacionesString=$predioDato->observaciones;
    
            }
    
    
            $ciudadesCI=array(0=>"Cochabamba",1=>"Santa Cruz",2=>"La Paz",3=>"Oruro",4=>"Potosi",5=>"Tarija",6=>"Chuquisaca",7=>"Beni",8=>"Pando",9=>"Extranjero",10=>"Otros");
    
            $propietarioString="";
            $propietarioCIString="";

            //propietario juridico control
            $tipoPropietario = 0;//0 natural 1 juridica
            $razonSocialNombre = "";
            $razonSocialNit = "";

            $listaPropietarios=DatosPropietarioController::getListDatosPropietarioByIdPredio($idPredio);
            //  $propietarioString=count($listaPropietarios);
            foreach ($listaPropietarios as $propietario){
                 
                if(empty($propietario->numeroNIT) == false || empty($propietario->denominacion) == false)
                {
                    $tipoPropietario = 1;
                    $razonSocialNombre = $propietario->denominacion;
                    $razonSocialNit = $propietario->numeroNIT;
                }
    
                $propietarioString.=$propietario->nombres." ".$propietario->apellidoUno." ".$propietario->apellidoDos;
                if($propietario->numeroDocumento)
                    $propietarioCIString.="CI:".$propietario->numeroDocumento." ".$ciudadesCI[$propietario->idEmitidoEn];
                if(isset($propietario->matricula) && isset($propietario->asiento)){
                    if(strlen($propietario->matricula)>0 && strlen($propietario->asiento)>0){
                        $informacionLegalUno="Matricula: ".$propietario->matricula;
                        $informacionLegalDos="Asiento: ".$propietario->asiento;
                    }else{
                        if($propietario->fojas && $propietario->partida){
                            $informacionLegalUno="Fojas: ".$propietario->fojas;
                            $informacionLegalDos="Partida: ".$propietario->partida;
                        }
                    }
                }else{
                    if(isset($propietario->fojas) && isset($propietario->partida)){
                        $informacionLegalUno="Fojas: ".$propietario->fojas;
                        $informacionLegalDos="Partida: ".$propietario->partida;
                    }
                }
                if(isset($propietario->fechaRegistroDDRR)){
                    $fechasTmp=explode("-", $propietario->fechaRegistroDDRR);
                    $diaTmp=explode(" ", $fechasTmp[2]);
                    if($fechasTmp[0]!="0000")
                        $informacionLegalFecha="Fecha DDRR:".$diaTmp[0]."/".$fechasTmp[1]."/".$fechasTmp[0];
                }
    
                break;
            }



    
            $imagenPredioController=new ImagenPredioController();
            $urlCroquis=$imagenPredioController->getURLCroquisByIdPredio($idPredio);
            $urlUbicacion=$imagenPredioController->getURLUbicacionByIdPredio($idPredio);
            $urlFachadaUno=$imagenPredioController->getURLFachadaUnoByIdPredio($idPredio);
            $urlFachadaDos=$imagenPredioController->getURLFachadaDosByIdPredio($idPredio);
            $urlOtros=$imagenPredioController->getURLOtrosByIdPredio($idPredio);
    
            $servicioController=new ServicioController();

            //esto era en version anterior antes 30-08-2018
            //$listaServicios=$servicioController->getListServiciosByIdPredio($idPredio);

            //se agrego para control de repeticiones en servicios al imprimir actualiza el predioservicio si hay duplicados
            $lipsupda = $servicioController->actualizarPredioServicioForDeleteDuplicates($idPredio);
            $listaServicios=$servicioController->getListServiciosByIdPredio($idPredio);
            //end se agrego para control de repeticiones en servicios al imprimir

            $listaTipologias=array();
            $listaSumaPuntajeBloqueDato=array();
            $bloquesDato=new BloquesDatoController();
            $listaBloqueDatosBloque=$bloquesDato->getBloques($idPredio);
            foreach ($listaBloqueDatosBloque as $bloqueDato){
                //nuevo recalculo de puntajes para los bloques
                ValoresBloqueController::recalcularPuntajes($bloqueDato->idBloqueDato);
                //end nuevo recalculo de puntajes para los bloques
                $puntaje=ValoresBloqueController::getSumaPuntajeByIdBloqueDato($bloqueDato->idBloqueDato);
                $puntaje= floor($puntaje);
                $listaSumaPuntajeBloqueDato[$bloqueDato->idBloqueDato]=$puntaje;
                $topologiaConstructiva=TipologiasConstructivaController::getTipologiaByPuntaje($puntaje);
                $listaTipologias[$bloqueDato->idBloqueDato]=$topologiaConstructiva->descripcion;
            }
            $listaBloqueDatosMejora=$bloquesDato->getMejoras($idPredio);
            foreach ($listaBloqueDatosMejora as $bloqueDato){
                //nuevo recalculo de puntajes para las mejoras
                ValoresBloqueController::recalcularPuntajes($bloqueDato->idBloqueDato);
                //end nuevo recalculo de puntajes para las mejoras
                $puntaje=ValoresBloqueController::getSumaPuntajeByIdBloqueDato($bloqueDato->idBloqueDato);
                $puntaje= floor($puntaje);
                $listaSumaPuntajeBloqueDato[$bloqueDato->idBloqueDato]=$puntaje;
                $topologiaConstructiva=TipologiasConstructivaController::getTipologiaByPuntaje($puntaje);
                $listaTipologias[$bloqueDato->idBloqueDato]=$topologiaConstructiva->descripcion;
            }
    
    
            

            //agregado Ruddy
            //control de tipo de usuario para la impresion del numero de formulario si es 0 es usuario normal y se incrementa el numero de formulario de lo contrario no
            if ($tipoUsuario == 0) {
                $avaluoTemporalComparacion = AvaluoController::getAvaluoByPrintByIdPredio($idPredio);
                if ($avaluoTemporalComparacion->estadoAvaluo == 1) {
                    $avaluo =AvaluoController::getAvaluoByPrintByIdPredio($idPredio);
                }
                else
                {
                    $avaluo=AvaluoController::getAvaluoActualizadoByPrintByIdPredio($idPredio);
                }

                
            }elseif ($tipoUsuario == 1) {
                $avaluo =AvaluoController::getAvaluoByPrintByIdPredio($idPredio);
            }else{
                $avaluo =AvaluoController::getAvaluoByPrintByIdPredio($idPredio);
            }

            
            if (empty($avaluo->fechaImpresion) || is_null($avaluo->fechaImpresion)) {
                $fechaImpresionTMP = explode("-", date("Y-m-d H:i:s"));
            }
            else
            {
                $fechaImpresionTMP = explode("-", $avaluo->fechaImpresion);
            }

            
            $fechaImpresion=explode(" ",$fechaImpresionTMP[2])[0]."/".$fechaImpresionTMP[1]."/".$fechaImpresionTMP[0];
            $nroFormulario = $avaluo->numeroFormulario;
    
            $codigoImpresion="I".$idPredio."F".$nroFormulario;
    
            $profesional=$user->nombres." ".$user->apellidos;
            $nroRegistroProfesional=$user->numeroRegistro;
    
            $urlQR=$this->generarQRCode($avaluo->numeroFormulario,$fechaImpresion,$profesional,$predio,$propietarioString);
            
            $matrizData=$this->getMatriz($idPredio);
            $matriz=$matrizData["matriz"];
            $observacionesGenerales=$matrizData["observacionesGenerales"];
            
    
            $pdf = \App::make('dompdf.wrapper');
            //$pdf=new PDF($dompdf, $config, $files, $view);
            //dd($matriz);
            $view =  \View::make('pdf.general', compact(
                'cuentaValida',
                'errorOcurrido',
                'user',
                'profesional',
                'nroRegistroProfesional',
                'nroFormulario',
                'predio',
                'predioDato',
                'zonaHomogeneaString',
                'coeficienteTopograficoString',
                'ubicacionPredioString',
                'materialViaString',
                'formaPredioString',
                'frenteString',
                'fondoString',
                'superficieAprobadaString',
                'observacionesString',
                'informacionLegalUno',
                'informacionLegalDos',
                'informacionLegalFecha',
                'propietarioString',
                'propietarioCIString',
                'urlCroquis',
                'urlUbicacion',
                'urlFachadaUno',
                'urlFachadaDos',
                'urlOtros',
                'listaServicios',
                'listaBloqueDatosBloque',
                'listaBloqueDatosMejora',
                'listaSumaPuntajeBloqueDato',
                'listaTipologias',
                'fechaImpresion',
                'codigoImpresion',
                'urlQR',
                'matriz',
                'observacionesGenerales',
                'tipoPropietario',
                'razonSocialNombre',
                'razonSocialNit'
            ))->render();
                
            } catch (\Exception $e) {

                $pdf = \App::make('dompdf.wrapper');

                $errorOcurrido = 1;
                $mensajeError = $e->getMessage().' '.$e->getLine();
                $view = \View::make('pdf.general',compact(
                    'errorOcurrido',
                    'cuentaValida',
                    'mensajeError'
                    ))->render();
                $pdf->loadHTML($view);
                $orientation = 'landscape';
                $customPaper = array(0,0,810,600);
                $pdf->setPaper($customPaper, $orientation);
                return $pdf->stream('invoice');
                
            }
    
        }
        else
        {
            $view =  \View::make('pdf.general', compact(
                'cuentaValida'
            ))->render();
        }
    

        

    
        //$pdf = \App::make('dompdf.wrapper');
        //$pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper('A4','portrait');
        
        //$pdf=new PDF($dompdf, $config, $files, $view);
        
       $orientation = 'landscape';
        $customPaper = array(0,0,810,600);
        $pdf->setPaper($customPaper, $orientation);
        
       /* $domPDFX=$pdf->getDomPDF();
        $domPDFX->set_option("enable_php", true);
        
        $canvas = $domPDFX->get_canvas();
        $domPDFX->
        $canvas->text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));*/
        
        return $pdf->stream('invoice');



    }
    
    private function generarQRCode($numeroFormulario,$fechaImpresion,$profesional,$predio,$propietarioString){
        /*$qr=QrCode::format('png')
        ->size(100)
        ->margin(0)
        ->errorCorrection('H')
        ->generate("Form: $numeroFormulario \nProf:$profesional", '../public/qrcodes/'.$numeroFormulario.'.png'); 
        return "qrcodes/$numeroFormulario.png";*/

        //FORMA ANTIGUA EN DONDE SE GENERABA UN ARCHIVO PNG PARA DESPUES REFERIRLA COMO UNA URL
        // $qr=QrCode::format('png')
        // ->size(100)
        // ->margin(0)
        // ->errorCorrection('H')
        // ->generate("GAMC-DAGC-$numeroFormulario \nInm:$predio->numeroInmueble \nCoCat:$predio->codigoCatastral \nNoPr:$propietarioString \nProf:$profesional \nFech:$fechaImpresion", '../public/qrcodes/'.$numeroFormulario.'.png'); 
        // return "qrcodes/$numeroFormulario.png";

        //NUEVA FORMA DE GENERAR EL CODIGO QR EN FORMATO BASE64 QUE NO GUARDA UN ARCHIVO SINO UN STRING QUE SE INTERPRETA COMO LA IMAGEN
        $qrbase64 = base64_encode(QrCode::format('png')
        ->size(100)
        ->margin(0)
        ->errorCorrection('H')
        ->generate("GAMC-DAGC-$numeroFormulario \nInm:$predio->numeroInmueble \nCoCat:$predio->codigoCatastral \nNoPr:$propietarioString \nProf:$profesional \nFech:$fechaImpresion"));
        return $qrbase64;
    }
    
    
}
