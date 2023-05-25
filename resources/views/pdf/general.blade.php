<!DOCTYPE html>
<html lang="en"><head>
    <style type="text/css">
        
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
    {!! Html::style('assets/css/pdf.css') !!}
  </head><body>
  <?php if($cuentaValida && $errorOcurrido == 0){

        $numeroBloques = count($listaBloqueDatosBloque);
        $numeroBloqueMejoras = count($listaBloqueDatosMejora);
        $numeroTotalCaracteristicas = $numeroBloques+$numeroBloqueMejoras;
        $limite = 10;
        $numeroRepeticion = intval(ceil($numeroTotalCaracteristicas/$limite));
        
        if($numeroRepeticion == 0)
        {
            $numeroRepeticion = 1;
        }

        $indicePaginas = 1;

        //nuevas mejoras 30/08/2018
        $banderaTamanioBloques = false;
        if(count($listaBloqueDatosBloque) == 1 && count($listaBloqueDatosMejora) == 0)
        {
            $bdUnico = $listaBloqueDatosBloque[0];
            if($bdUnico->anioConstruccion == 0)
            {
                $listaBloqueDatosBloque = [];
                $banderaTamanioBloques = true;
            }
        }
        //end nuevas mejoras 30/08/2018
        $listaTotalCaracteristicas = array_merge($listaBloqueDatosBloque,$listaBloqueDatosMejora);

        $contador=0;

        $i=0;


        //manejo de la matriz para la tabla de caracteristicas
        $tamanioMatrizAlto = count($matriz);
        $tamanioMatrizAncho = count($matriz[0]);

        $limiteCorteMatriz = 10;

        //se resta 2 a ancho de la matriz para omitir las clomunas de titulos
        $numeroRepeticionMatriz = intval(ceil(($tamanioMatrizAncho -2) / $limiteCorteMatriz));

        //copiado de matriz

        $copiaMatriz=array();
        $inicioCorte=3;
        $finCorte=14;
        $banderaLimiteMatriz = intval(ceil($tamanioMatrizAncho / $limiteCorteMatriz));
        $numeroHojas = $numeroRepeticion + $numeroRepeticionMatriz;

        //nuevas mejoras 30/08/2018
        if($banderaTamanioBloques == true)
        {
            $numeroHojas = 1;
        }
        //end nuevas mejoras 30/08/2018

        //nuevas mejoras 30/08/2018 NOTA PARA LA SEGUNDA HOJA SE PUSO EN SU WHILE UNA CONDICION PARA QUE NO MUESTRE SI TIEN UN BLOQUE CON GESTION Y ANIO 0 QUE ES EL BLOQUE
        //GENERADO POR DEFECTO while ($numeroRepeticionMatriz > 0 && $banderaTamanioBloques == false) 
        //si se queire que esta hoja tambien salga se quita la segunda condicion y se quita el lo siguiente 
        //$numeroHojas = 1 para que salgan las dos hojas

        while ($numeroRepeticion >0) 
        {

    ?>
      <!-- CABECERA -->    
       <div id="details" class="clearfix">
        <div style="height: 120">
            <table class="table-header">
                <tbody>
                    <tr>
                        <td valign="top"><img height="100" src="assets/css/escudoCbba.png" alt="logo" width="80px" /></td>
                        <td valign="top"><img style="margin-top: 30px;margin-left: -220px;" src="assets/css/eslogan1Cbba.png" alt="logo" width="100px" /></td>
                        <td colspan="">
                            <div class="rotulo-informe" style="margin-left: -600px"><strong>GOBIERNO AUTONOMO MUNICIPAL DE COCHABAMBA</strong><br>
                            FORMULARIO PARA ACTUALIZACION DE DATOS TECNICOS<br>
                            DECLARACION JURADA
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                    <table>
                        
                            <tr>
                            <td width="480px">
                                <div style="margin-top: -10px" class="codigo-catastral-val-titulo">{{ $predio->codigoCatastral }}<br></div>
                                <div class="texto-centrado"> C&oacute;digo catastral</div>
                            </td>
                            <td width="100px">
                                    <div style="margin-top: -10px" class="codigo-catastral-val-titulo">{{ $predio->numeroInmueble}}</div>
                                    <div class="texto-centrado"># Inmueble</div>
                            </td>
                            <td valign="top" class="codigoQR">
                                <img alt="codigo qr" src="data:image/png;base64,{!!$urlQR!!}" style="margin-top: -130px;" width="140" height="140"/> 

                                <div style="margin-top: -10px;font-size: 10px;margin-right: 5px;text-align: center;font-family:  Sans-serif;font-weight: bold;">{{ $predio->pmc}}</div>
                                <div style="text-align: center;font-size: 10px;">PMC</div>

                            </td>
                        </tr>
                        
                    </table> 
                    </tr> 
                </tbody>
            </table>


        </div>
      </div>
      <!-- FIN CABECERA -->

<div><!--este tag era antes un main pero ocurrio problemas con el dompdf no se porque asi que lo cambie por div--> 

    <table class="columna-bloques-border">
        <tbody>
         <tr class="tabla-sombreada">
            <td valign="top" colspan="4"  width="140px">
                <strong> 1.- Informaci&oacute;n del propietario</strong>
                <?php
                    if($tipoPropietario == 0)
                    {
                ?>
                    <div >{{$propietarioString}}<br>{{$propietarioCIString}}<br></div>
                <?php
                    }else
                    {
                ?>
                    <div >{{$razonSocialNombre}}<br>{{$razonSocialNit}}<br></div>    
                <?php
                    }
                ?>
                
            </td>
            <td valign="top" colspan="3" >
                <strong>2.- Informaci&oacute;n legal</strong>
                <div >
                {{$informacionLegalUno}}<br>
                {{$informacionLegalDos}}<br>
                {{$informacionLegalFecha}}<br>              
                </div>                
            </td>
            <td valign="top" colspan="2" >
                <div>Formulario No.: <strong>{{$nroFormulario}}</strong><br> Fecha: <strong>{{$fechaImpresion}}</strong> <br> C&oacute;digo: <strong>{{$codigoImpresion}}</strong></div>
            </td>
         </tr>
            <tr>
                <td colspan="5" rowspan="2" align="center" class="columna-bloques-border" >
                    <strong>Croquis del predio</strong>
                                    <div style="width: 8cm;height: 320px; vertical-align: middle; text-align: center;" >
                                        <img src="{{$urlCroquis}}" alt="logo" style="max-width: 8cm;max-height: 320px;"/>
                                    </div>
                                    <img height="30px" width="30px" style="margin-left: 340px" src="assets/css/flechaNorte.png" alt="logo" />
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
                                <div style="text-align: center"><img src="{{$urlOtros}}" alt="logo" style="max-width: 4cm;max-height: 150px;" /></div></td>
                <td colspan="2" valign="top" class="columna-bloques-border">
                    <strong>Croquis de ubicaci&oacute;n</strong>
                                    <div style="text-align: center"> <img src="{{$urlUbicacion}}" alt="logo" style="max-width: 4cm;max-height: 150px;"  /></div>
                </td>
            </tr>

            <tr class="tabla-sombreada">
            <td colspan="3" valign="top" width="210px" >
                <strong>3.- Descripci&oacute;n del predio</strong>
                            <div class="zonas-homogeneas_div">
                                Calle: {{$predio->direccion}}<br>
                                Edificio: {{$predio->nombreEdificio}}, Piso: {{$predio->piso}}, Dpto: {{$predio->departamento}}<br>
                                Ltd.: {{ round($predio->latitud,7)}}, Lgt.: {{round($predio->longitud,7)}}
                            </div>
            </td>

            <td colspan="2" valign="top" width="150px">
                <div class="zonas-homogeneas_div">
                                    Frente de lote: {{$frenteString}}<br>
                                    Fondo del lote: {{$fondoString}}<br>
                                    Superficie Lote: {{$superficieAprobadaString}}<br>
                                    Ubicaci&oacute;n: {{$ubicacionPredioString}}<br>
                                </div>
            </td>
            <td colspan="2" valign="top" width="170px">
                <div class="zonas-homogeneas_div">
                                    Zona homog&eacute;nea: {{$zonaHomogeneaString}}<br>
                                    Material v&iacute;a: {{$materialViaString}}<br>
                                    {{$coeficienteTopograficoString}}<br>
                                    Forma: {{$formaPredioString}}<br>
                                </div>

            </td>
            <td colspan="2" valign="top" width="130px">
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
                <strong>6.- Caracteristicas de la(s) construcciones</strong>
                    <div >
                    <?php 
                    if(count($listaBloqueDatosBloque)>0 || count($listaBloqueDatosMejora)>0){
                    ?>
                        <table class="tabla-bloques">
                            <tr class= "tabla-sombreada" >
                                <th rowspan="2" class="td-titulo">Nro.</th>
                                <th colspan="2" class="td-titulo">A&ntilde;o</th>
                                <th rowspan="2" class="td-titulo">Bloque</th>
                                <th rowspan="2" class="td-titulo">Sup. cons.</th>
                                <th rowspan="2" class="td-titulo">Pisos</th>
                                <th rowspan="2" class="td-titulo">Tipolog&iacute;a</th>
                                <th rowspan="2" class="td-titulo">Puntaje</th>
                            </tr>
                            <tr class="tabla-sombreada">
                               <th class="td-titulo">Modif.</th>
                               <th class="td-titulo">Constr.</th> 
                            </tr>
                            <?php 
                            
                                
                                while($i<$limite && $numeroBloques > 0){
                                    $contador++;
                                    
                                    if($listaTotalCaracteristicas[$contador - 1]->anioConstruccion != 0)
                                    {
                                    ?>
                                    <tr>
                                        <th><?php echo $contador?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->gestion?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->anioConstruccion?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->numerobloque?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->superficieBloque?> M2</th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->cantidadPisos?></th>
                                        <th><?php echo $listaTipologias[$listaTotalCaracteristicas[$contador - 1]->idBloqueDato]?></th>
                                        <th><?php echo "-"?></th>
                                        <!-- <th><?php echo $listaSumaPuntajeBloqueDato[$listaTotalCaracteristicas[$contador - 1]->idBloqueDato]?></th> -->
                                        
                                    </tr>

                                    <?php 
                                    }
                                        $i++;
                                        $numeroBloques--;
                                 } 
                                  if($numeroBloques == 0 && $i < $limite){
                                    while ($i < $limite && $numeroBloqueMejoras > 0) {
                                        $contador++;
                                        ?>

                                    <tr >
                                        <th><?php echo $contador?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->gestion?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->anioConstruccion?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->tipoMejora?></th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->superficieBloque?> M2</th>
                                        <th><?php echo $listaTotalCaracteristicas[$contador - 1]->cantidadPisos?></th>
                                        <th><?php echo $listaTipologias[$listaTotalCaracteristicas[$contador - 1]->idBloqueDato]?></th>
                                        <th><?php echo $listaSumaPuntajeBloqueDato[$listaTotalCaracteristicas[$contador - 1]->idBloqueDato]?></th>
                                        
                                     </tr>

                                     <?php
                                     $i++;
                                     $numeroBloqueMejoras--;

                                    }
                                    
                                    ?>
                                    
                                        <?php 
                                 } ?>
                            
                        </table>
                        <?php 
                        }

                        else{
                            echo "Sin bloques o mejoras registrados";
                        }


                        $i=0;

                        $numeroRepeticion--;



                        ?>
                    </div>
                </td>
                <td colspan="4" valign="top" class="texto-juramento" >En mi calidad de sujeto pasivo y/o tercero responsable, declaro que la información proporcionada en la determinación del IPBI, fiel y exactamente refleja la verdad, por lo que juro a la exactitud de la presente declaración (Art.78,I, Ley 2492).</td>                
            </tr>
            <tr>
                <td colspan="4" valign="top" class="texto-juramento" >.<br>
                .<br><br></td> 
            </tr>
            <tr >
                <td colspan="2" valign="bottom" style="border-bottom: 1px solid #808080;">
                <div class="propietario-profesional">
                    -------------------<br>
                    

                    <?php
                    if($tipoPropietario == 0)
                        {
                    ?>
                        Firma del propietario<br>
                    <?php
                        }else
                        {
                    ?>
                        Representante legal<br> 
                    <?php
                        }
                    ?>

                    {{$propietarioString}}<br>
                    {{$propietarioCIString}}<br>
                 </div>   
                </td>
                <td colspan="2" valign="bottom" style="border-bottom: 1px solid #808080;">
                <div class="propietario-profesional">
                     -------------------<br>
                    Firma del profesional<br>
                    Nro. registro:{{$nroRegistroProfesional}}<br>
                    {{$profesional}}<br>
                    </div>
                </td>
            
            </tr>
            <tr class = "tabla-sombreada columna-bloques-border">
            <td colspan="9" valign="top" ><strong>7.- Observaciones</strong>
                                <div>
                                    {{$observacionesString}}
                                </div> 
            </td>
            </tr>

        </tbody>
    </table>
    <div style="text-align: right;font-size: 6px">P&aacute;gina <?php echo $indicePaginas;?>/<?php echo $numeroHojas;?></div>
</div>
      <!--<br><table style='page-break-after:always;'></br></table><br> -->
      <?php
        if(count($listaBloqueDatosBloque)>0 || count($listaBloqueDatosMejora)>0)
        {
      ?>
            <div style='page-break-after:always;'></div>
      <?php
        }
      ?>
      <?php
       $indicePaginas++;
  }
      ?>
      
      
      
      <?php

      while ($numeroRepeticionMatriz > 0 && $banderaTamanioBloques == false) {
          
      if($numeroRepeticionMatriz > 0)
      {
        $k=0;
        
        foreach ($matriz as $ma) {

            $copiaMatriz[$k]["col1"] = $ma["col1"];
            $copiaMatriz[$k]["col2"] = $ma["col2"];

            //copiado de las columnas que faltan

            if($tamanioMatrizAncho < 15)
            {
                $finCorte = $tamanioMatrizAncho+1;
            }
            
            for ($i=$inicioCorte; $i < $finCorte; $i++) { 
                $copiaMatriz[$k]["col".$i] = $ma["col".$i];
            }


            $k++;
        }
      }



    ?>
      
      <div  class="clearfix">
        <div style="height: 120">
            <table class="table-header">
                 <tbody>
                    <tr>
                        <td valign="top"><img height="100" src="assets/css/escudoCbba.png" alt="logo" width="80px" /></td>
                        <td valign="top"><img style="margin-top: 30px;margin-left: -220px;" src="assets/css/eslogan1Cbba.png" alt="logo" width="100px" /></td>
                        <td colspan="">
                            <div class="rotulo-informe" style="margin-left: -600px"><strong>GOBIERNO AUTONOMO MUNICIPAL DE COCHABAMBA</strong><br>
                            FORMULARIO PARA ACTUALIZACION DE DATOS TECNICOS<br>
                            DECLARACION JURADA
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                    <table>
                        
                            <tr>
                            <td width="480px">
                                <div style="margin-top: -10px" class="codigo-catastral-val-titulo">{{ $predio->codigoCatastral }}<br></div>
                                <div class="texto-centrado">C&oacute;digo catastral</div>
                            </td>
                            <td width="100px">
                                    <div style="margin-top: -10px" class="codigo-catastral-val-titulo">{{ $predio->numeroInmueble}}</div>
                                    <div class="texto-centrado"># Inmueble</div>
                            </td>
                            <td valign="top" class="codigoQR">
                                <img alt="codigo qr" src="data:image/png;base64,{!!$urlQR!!}" style="margin-top: -130px" width="140" height="140"/>

                                <div style="margin-top: -10px;font-size: 10px;margin-right: 5px;text-align: center;font-family:  Sans-serif;font-weight: bold;">{{ $predio->pmc}}</div>
                                <div style="text-align: center;font-size: 10px;">PMC</div>

                            </td>
                        </tr>
                        
                    </table> 
                    </tr> 
                </tbody>
            </table>
        </div>
      </div>
      <!-- FIN CABECERA -->
      <div>
          <table class="tabla-bloques-1 "  >
            <tbody>
              <?php 
              $filaCero=0;
              $contadorTipoCaracteristica=0;
              $contFila = 0;
              foreach ($copiaMatriz as $fila){

                //con el -1 se omite la fila total donde se suma los puntajes
                if ($contFila != $tamanioMatrizAlto-1) {


                    ?>
                    <tr>
                    <?php
                    
                        
                    


                  $contadorCol=1;
                  foreach ($fila as $index=>$col){
                      if($contadorCol==1){
                          
                          if($fila["col2"]=="" && $fila["col2"] !==0){
                              $contadorTipoCaracteristica++;
                              if($col=="TOTAL")
                                  $contadorTipoCaracteristica="";
                              echo "<td class='td-titulo-tipo-caracteristica '>$contadorTipoCaracteristica  $col</td>";
                          }else echo "<td class='td-titulo-caracteristica'>$col</td>";
                      }
                      else if ($contadorCol != 2) {

                            if ($col == "0") {
                                $col = "";
                            }

                          echo "<td class='td-titulo-columna'>$col</td>";
                      }
                        
                      $contadorCol++;
                  }
                  
                    ?>
                    </tr>
                    <?php
                }
                $contFila ++;
                     
              }
              ?>
              </tbody>
          </table>
      </div>
      <div style="font-size:9px;" ><strong>Observaciones:</strong><br>{{$observacionesGenerales}}</div>
      <div style="text-align: right;font-size: 6px">P&aacute;gina <?php echo $indicePaginas;?>/<?php echo $numeroHojas;?></div>

        <?php
            if($numeroRepeticionMatriz > 1)
            {
        ?>
            <div style='page-break-after:always;'></div>
        <?php            
            }
        ?>
      
      
      <?php
        
                $numeroRepeticionMatriz --;
                if($numeroRepeticionMatriz == 1)
                {
                    $inicioCorte = $inicioCorte + 11;
                    $finCorte = $tamanioMatrizAncho+1;
                }
                else
                {
                    $inicioCorte = $inicioCorte + 11;
                    $finCorte = $finCorte + 11;
                }

                $copiaMatriz = array();
                $indicePaginas++;


            }

            

       }
      else{
            //si ocurrio algun error Ruddy
            if ($errorOcurrido == 1) {
                echo "Existe un error en sus datos, edite y guarde nuevamente los datos del predio, propietario y los bloques de este formulario";
                //echo $mensajeError;
            }
            if (!$cuentaValida) {
                echo "La cuenta no es valida";
            }
            //echo "otro error";
      }?>
  </body></html>