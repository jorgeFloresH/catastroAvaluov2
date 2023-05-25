<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
    {!! Html::style('assets/css/pdf.css') !!}
  </head>
  <body>

      <!-- CABECERA -->    
      <div id="details" class="clearfix">
        <div>
            <table class="table-header">
                <tr>
                    <td rowspan="2">
                        <img alt="logo" src="assets/css/escudo_gam_cbba_grande.png" width="70px">
                    </td>
                    <td colspan="3">
                    <div class="rotulo-informe">Gobierno autonomo municipal de cochabamba<br>Formulario para actualización de datos t&eacute;cnicos</div>
                    </td>
                </tr>
                <tr>
                    <td>Nro Inmueble<br>{{ $nroInmueble }}</td>
                    <td>
                        C&Oacute;DIGO CATASTRAL<br>
                        <div class="codigo-catastral-val-titulo">{{ $codigoCatastral }}</div>
                    </td>
                    <td>
                        <div class="formulario-nro">Formulario Nro</div>
                        {{$nroFormulario}}
                        Fecha:15/05/2016<br>
                        Código:AZB1B1U1245
                    </td>
                </tr>
            </table>
          
        </div>
        
      </div>
      <!-- FIN CABECERA -->
      
      
      <main> 
      
      <table>
      <tbody>
        <tr>
            <td >
                <h5 class="h5-subtitulo">1.-informaci&oacute;n del propietario</h5>
                <div></div>
            </td>
            <td>
                <h5 class="h5-subtitulo">2.-informaci&oacute;n legal</h5>
                <div></div>
            </td>
            <td>
                <img alt="codigo qr" src="assets/css/qrcode_url.jpeg" width="50px">
            </td>
        </tr>
        <tr>
            <td>
                <h5 class="h5-subtitulo">Croquis del predio</h5>
                <div></div>
                <h5 class="h5-subtitulo">3.- Direcci&oacute;n del predio</h5>
                <div></div>
            </td>
            <td colspan="2">
                <h5 class="h5-subtitulo">Croquis de ubicaci&oacuet;n</h5>
                <div></div>
                <h5 class="h5-subtitulo">Fachada</h5>
                <div></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table>
                <tr>
                <td>
                    <h5 class="h5-subtitulo">4.- Datos del predio</h5>
                    <div></div>
                </td>
                <td>
                    <h5 class="h5-subtitulo">5.- Detalle del predio</h5>
                    <div></div>
                </td>
                </tr>
                </table>
            <td>
        </tr>
        <tr>
            <td colspan="3">
                <table>
                <tr>
                <td>
                    <h5 class="h5-subtitulo">4.- Datos del predio</h5>
                    <div></div>
                </td>
                <td>
                    <h5 class="h5-subtitulo">5.- Detalle del predio</h5>
                    <div></div>
                </td>
                </tr>
                </table>
            <td>
        </tr>
        </tbody>
        
      </table>
      <div class="footer" align="right">
          <table class="tabla-footer">
            <tbody>
                <tr>
                <td class="td-col-primero">
                </td>
                <td>
                    Firma del propietario<br>
                    CI:245222<br>
                    Angel Rico Almaraz<br>
                </td>
                <td>
                    Firma del profesional<br>
                    Nro registro:125<br>
                    Juan Carlos Medinacelli<br>
                </td>
                </tr>
            <tbody>
          </table>
      </div>
      
      
      
      <!-- <table>
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no">{{ $data['quantity'] }}</td>
            <td class="desc">{{ $data['description'] }}</td>
            <td class="unit">{{ $data['price'] }}</td>
            <td class="total">{{ $data['total'] }} </td>
          </tr>

        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td >TOTAL</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>
      </table> -->
      </main>
  </body>
</html>