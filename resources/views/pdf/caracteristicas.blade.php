<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
        
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
    {!! Html::style('assets/css/pdf.css') !!}
  </head>
  <body>
  <?php if($cuentaValida){?>
      <!-- CABECERA -->    
       <div id="details" class="clearfix">
        <div>
            <table class="tabla-header">
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
                    <td valign="top" class="codigoQR">.-.
                        
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
          <table class="tabla-caracteristicas" border="1px" >
            <tbody>
              <?php 
              $contadorTipoCaracteristica=0;
              foreach ($matriz as $fila){
                  ?>
                  <tr>
                  <?php 
                  $contadorCol=1;
                  foreach ($fila as $index=>$col){
                      if($contadorCol==1){
                          
                          if($fila["col2"]==""){
                              $contadorTipoCaracteristica++;
                              if($col=="TOTAL")
                                  $contadorTipoCaracteristica="";
                              echo "<td class='td-titulo-tipo-caracteristica'>$contadorTipoCaracteristica  $col</td>";
                          }else echo "<td class='td-titulo-caracteristica'>$col</td>";
                      }else echo "<td class='td-titulo-columna'>$col</td>";
                      
                    
                      $contadorCol++;
                      
                  }
                  ?>
                  </tr>
                  <?php 
              }
              ?>
              </tbody>
          </table>
      </div>
      <?php }else{
      echo "La cuenta no es valida";
      }?>
  </body>
</html>