<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
        
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Formulario</title>
    {!! Html::style('assets/css/pdf.css') !!}
  </head>
  <body>
  
  <?php if($cuentaValida){?>
      <!-- CABECERA -->    
       <div id="details" class="clearfix">
        <div>
            <table class="table-header">
                <tbody>
                    <tr>
                        <td rowspan="" valign="top"><img src="assets/css/escudoCbba.png" alt="logo" width="80px" /></td>
                        <td colspan="3" ><div class="rotulo-informe" ><strong>GOBIERNO AAUTONOMO MUNICIPAL DE COCHABAMBA</strong><br>
                            FORMULARIO PARA ACTUALIZACION DE DATOS TECNICOS<br>
                            DECLARACION JURADA
                            </div>
                        </td>
                        <td rowspan="" valign="top" class="codigoQR"><img src="assets/css/eslogan1Cbba.png" alt="logo" width="100px" /></td>
                    </tr>
                    <!-- <tr> 
                        <td colspan="3"><div>
                            .</div>
                        </td> -->
                    </tr>
                    <tr>
            <table >
                <tr>
                    <td><div class="codigo-catastral-val-titulo">{{ $predio->codigoCatastral }}<br></div>
                            <div class="texto-centrado"> C&oacute;digo catastral</div>
                    </td>
                    <td >
                            <div class="codigo-catastral-val-titulo">{{ $predio->numeroInmueble}}</div>
                            <div class="texto-centrado">Nro. de inmueble</div>
                    </td>
                    <td valign="top" class="codigoQR">
                        <img alt="codigo qr" src="{{$urlQR}}" /> 
                    </td>
                </tr>
            </table> 
                    </tr> 
                </tbody>
            </table>


        </div>
      </div>
      <!-- FIN CABECERA -->

<main> 



    <table class="columna-bloques-border">
        <tbody>
         <tr class="tabla-sombreada">
            <td valign="top" colspan="3" >
                <strong> 1.-informaci&oacute;n del propietario</strong>
                <div >{{$propietarioString}}<br>{{$propietarioCIString}}<br></div>
            </td>
            <td valign="top" colspan="3" >
                <strong>2.-informaci&oacute;n legal</strong>
                <div >
                {{$informacionLegalUno}}<br>
                {{$informacionLegalDos}}<br>
                {{$informacionLegalFecha}}<br>              
                </div>                
            </td>
            <td valign="top" colspan="3" >
                <div>Formulario No.: <strong>{{$nroFormulario}}</strong><br> Fecha: <strong>{{$fechaImpresion}}</strong> <br> C&oacute;digo: <strong>{{$codigoImpresion}}</strong></div>
            </td>
         </tr>
            <tr>
                <td colspan="5" rowspan="2" align="center" class="columna-bloques-border" >
                    <strong>Croquiss del predio</strong>
                                    <div style="width: 8cm;height: 320px; vertical-align: middle; text-align: center;" >
                                        <img src="{{$urlCroquis}}" alt="logo" style="max-width: 8cm;max-height: 320px;"/>
                                    </div>
                </td>
                <td colspan="2" valign="top" class="columna-bloques-border">
                    <strong>Fachada 1</strong>
                            <div style="text-align: center"><img src="{{$urlFachadaUno}}" alt="logo" style="max-width: 4cm;max-height: 150px;" /></div>
                </td>
                <td colspan="2" valign="top" class="columna-bloques-border">
                    <strong>Fachada 2</strong>
                            <div style="text-align: center"><img src="{{$urlFachadaDos}}" alt="logo" style="max-width: 4cm;max-height: 150px;" /></div>
                </td>
                
            </tr>
            <tr>
                <td colspan="2" valign="top" class="columna-bloques-border">
                    <strong>Interior</strong>
                                <div style="text-align: center"><img src="{{$urlFachadaUno}}" alt="logo" style="max-width: 4cm;max-height: 150px;" /></div></td>
                <td colspan="2" valign="top" class="columna-bloques-border">
                    <strong>Croquis de ubicaci&oacute;n</strong>
                                    <div style="text-align: center"> <img src="{{$urlUbicacion}}" alt="logo" style="max-width: 4cm;max-height: 150px;"  /></div>
                </td>
            </tr>

            <tr class="tabla-sombreada">
            <td colspan="2" valign="top" >
                <strong>3.- Descripci&oacute;n del predio</strong>
                            <div class="zonas-homogeneas_div">
                                Calle:{{$predio->direccion}}<br>
                                Edificio:{{$predio->nombreEdificio}}, Piso:{{$predio->piso}}, Dpto:{{$predio->departamento}}
                            </div>
            </td>

            <td colspan="2" valign="top">
                <div class="zonas-homogeneas_div">
                                    Frente de lote: {{$frenteString}}<br>
                                    Fondo del lote: {{$fondoString}}<br>
                                    Superficie aprobada: {{$superficieAprobadaString}}<br>
                                    Ubicaci&oacute;n: {{$ubicacionPredioString}}<br>
                                </div>
            </td>
            <td colspan="3" valign="top">
                <div class="zonas-homogeneas_div">               Zona homogenea: {{$zonaHomogeneaString}}<br>
                                    Material via: {{$materialViaString}}<br>
                                    {{$coeficienteTopograficoString}}<br>
                                    Forma: {{$formaPredioString}}<br>
                                </div>

            </td>
            <td colspan="2" valign="top">
                <div class="zonas-homogeneas_div">
                <?php 
                if(count($listaServicios)>0){
                    foreach ($listaServicios as $servicio){
                        echo $servicio->descripcion."<br>";
                    
                    }
                }else echo "Sin servicios";
                
                ?>
                </div>
            </td>
            </tr>
            <tr>
                 <td colspan="5" rowspan="3" valign="top" class="columna-bloques-border">
                <strong>6.- Caracteristicas de la (s) construcciones</strong>
                    <div >
                    <?php 
                    if(count($listaBloqueDatosBloque)>0 || count($listaBloqueDatosMejora)>0){
                    ?>
                        <table class="tabla-bloques">
                            <tr class= "tabla-sombreada" >
                                <th class="td-titulo">Nro</th>
                                <th class="td-titulo">Ges Mod/Ampl</th>
                                <th class="td-titulo">Bloque</th>
                                <th class="td-titulo">Sup cons</th>
                                <th class="td-titulo">Pisos</th>
                                <th class="td-titulo">Tipologia</th>
                                <th class="td-titulo">Puntaje</th>
                            </tr>
                            <?php 
                            
                                $contador=0;
                                foreach ($listaBloqueDatosBloque as $bloqueDato){
                                    $contador++;
                                    ?>
                                    <tr>
                                        <th><?php echo $contador?></th>
                                        <th><?php echo $bloqueDato->gestion?></th>
                                        <th><?php echo $bloqueDato->numerobloque?></th>
                                        <th><?php echo $bloqueDato->superficieBloque?> M2</th>
                                        <th><?php echo $bloqueDato->cantidadPisos?></th>
                                        <th><?php echo $listaTipologias[$bloqueDato->idBloqueDato]?></th>
                                        <th><?php echo $listaSumaPuntajeBloqueDato[$bloqueDato->idBloqueDato]?></th>
                                        
                                     </tr>
                                        <?php 
                                 } 
                                 foreach ($listaBloqueDatosMejora as $bloqueDato){
                                    $contador++;
                                    ?>
                                    <tr >
                                        <th><?php echo $contador?></th>
                                        <th><?php echo $bloqueDato->gestion?></th>
                                        <th><?php echo $bloqueDato->tipoMejora?></th>
                                        <th><?php echo $bloqueDato->superficieBloque?> M2</th>
                                        <th><?php echo $bloqueDato->cantidadPisos?></th>
                                        <th><?php echo $listaTipologias[$bloqueDato->idBloqueDato]?></th>
                                        <th><?php echo $listaSumaPuntajeBloqueDato[$bloqueDato->idBloqueDato]?></th>
                                        
                                     </tr>
                                        <?php 
                                 } ?>
                            
                        </table>
                        <?php 
                        }else{
                            echo "Sin bloques o mejoras registrados";
                        }
                        ?>
                    </div>
                </td>
                <td colspan="4" valign="top" class="texto-juramento" >En mi calidad de sujeto pasivo y/o tercero responsable, declaro que la información proporcionada en la determinación del IPBI, fiel y exactamente refleja la verdad, por lo que juro ala exactitud de la presente declaración (Art.78,I, Ley 2492).</td>                
            </tr>
            <tr>
                <td colspan="4" valign="top" class="texto-juramento" >.<br>
                .<br><br><br></td> 
            </tr>
            <tr >
                <td colspan="2" valign="bottom" style="border-bottom: 1px solid #808080;">
                <div class="propietario-profesional">
                    -------------------<br>
                    Firma del propietario<br>
                    {{$propietarioString}}<br>
                    {{$propietarioCIString}}<br>
                 </div>   
                </td>
                <td colspan="2" valign="bottom" style="border-bottom: 1px solid #808080;">
                <div class="propietario-profesional">
                     -------------------<br>
                    Firma del profesional<br>
                    Nro registro:{{$nroRegistroProfesional}}<br>
                    {{$profesional}}<br>
                    </div>
                </td>
            
            </tr>
            <tr class = "tabla-sombreada columna-bloques-border">
            <td colspan="9" valign="top" ><strong>7.- Observaciones</strong>
                                <div>
                                    {{$observacionesString}}<br><br>
                                </div> 
            </td>
            </tr>

        </tbody>
    </table>
      </main>
      <?php }else{
      echo "La cuenta no es valida";
      }?>
  </body>
</html>