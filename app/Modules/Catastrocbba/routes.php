<?php
Route::get('imagenes/{filename}', function ($filename)
{
    $path = storage_path() . '/uploads/' . $filename;
    //return $path; 

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::group(['prefix' => '/reporte/', 'namespace' => 'App\Modules\Catastrocbba\Controllers'], function (){
    Route::get('datosTecnicos/{idPredio},{idUsuario},{email}', 'PdfController@reporteFormularioGral');
    Route::get('datosCaracteristicas/{idPredio},{idUsuario},{email}', 'PdfController@reporteFormularioCaracteristicas');
    Route::get('datosGral/{idPredio},{idUsuario},{email}', 'PdfController@reporteFormularioActualizacionDatosTecnicos');
});
        
Route::group(['prefix' => 'catastrocbba/misc/', 'namespace' => 'App\Modules\Catastrocbba\Controllers'], function (){
    Route::post('fileUpload', 'PredioController@uploadFile');
    //Route::post('photoUpload', 'PredioController@uploadPhotoPredio');
    Route::post('resetPassword', 'UserController@resetPassword');
    Route::get('validacion', 'UserController@validacionCuenta');

	
	//agregado Ruddy
    Route::post('migrarImagenes','PredioController@migrarImagenes');
    Route::post('fileUpdate', 'ImagenPredioController@updateImagen');
    Route::get('migrarImagenesFtp/{idpredio}','PredioController@migrarImagenesFtp');
    
    
});
Route::group(['prefix' => 'catastrocbba/api/v1', 'namespace' => 'App\Modules\Catastrocbba\Controllers'], function (){    
    
        
        Route::get('employes/{id?}', 'Employes@index');
        Route::post('employes', 'Employes@store');
        Route::post('employes/{id}', 'Employes@update');
        Route::delete('employes/{id}', 'Employes@destroy');
        
        Route::get('usuarios', 'UserController@showAll');
        Route::get('usuarios/{id?}', 'UserController@show');
        Route::post('usuarios', 'UserController@store');
        Route::put('usuarios', 'UserController@update');
        Route::post('cambiarPassword', 'UserController@cambiarPassword');

        //agregado Ruddy
        Route::post('cambiarTipoUsuario', 'UserController@cambiarTipoUsuario');
        Route::post('usuariosByNombreApellido', 'UserController@showNombreApellido');
        Route::post('usuariosByEmail','UserController@showEmail');
        Route::get('usuariosById/{id?}','UserController@showById');

        
        
        Route::get('prediario/{idPredio},{tipoRelacion}', 'ImagenPredioController@getListImagenPredioByIdPredioIdTipoRelacion');
        Route::get('predios', 'PredioController@showAll');
        Route::get('predios/{id?}', 'PredioController@show');
        Route::post('predios', 'PredioController@store');
        Route::put('predios', 'PredioController@update');
		Route::post('predioUpdate', 'PredioController@update');
        Route::post('prediosAvaluoAndPredio', 'PredioController@storeAvaluoAndPredio');
        
        Route::get('prediosUsuario/{id?}', 'PredioController@getListPredioByIdUsuario');

		Route::post('prediosUsuarioCodigoCatastral', 'PredioController@getListPredioByIdUsuarioAndCodCatastral');
        Route::post('prediosUsuarioNroFormulario', 'PredioController@getListPredioByIdUsuarioAndNroFormulario');
        Route::post('prediosUsuarioApellido', 'PredioController@getListPredioByIdUsuarioAndApellido');

        Route::get('prediosServicioPorIdPredio/{id?}', 'PredioServicioController@getListPredioServicioByIdPredio');

        
        Route::get('avaluos', 'AvaluoController@showAll');
        Route::get('avaluos/{id?}', 'AvaluoController@show');
        Route::post('avaluos', 'AvaluoController@store');
        
        
        Route::get('bloquesdatos', 'BloquesDatoController@showAll');
        Route::get('bloquesdatos/{id?}', 'BloquesDatoController@show');
        Route::post('bloquesdatos', 'BloquesDatoController@store');
        Route::post('bloquesdatosupdate', 'BloquesDatoController@update');
        Route::post('bloquesdatosDelete', 'BloquesDatoController@delete');
        Route::get('bloquesdatospredio/{id?}', 'BloquesDatoController@getListBloquesDatoByIdPredio');
        Route::post('bloquesdatosAndValoresBloque', 'BloquesDatoController@storeBloqueDatoAndValoresBloque');
        Route::put('bloquesdatosAndValoresBloqueUpdate', 'BloquesDatoController@updateBloqueDatoAndValoresBloque');
        
        Route::post('updatevalor', 'ValoresBloqueController@update');
        /*******PRUEBAS********/
        Route::get('testBD/{idUsuario}', 'BloquesDatoController@getListBloquesDatoByIdUsuarioTEST');
		
		     
        Route::get('bloquesdatosBloques/{idPredio}', 'BloquesDatoController@getBloques');
        Route::get('bloquesdatosMejoras/{idPredio}', 'BloquesDatoController@getMejoras');
        Route::get('tipologia/{puntaje}', 'TipologiasConstructivaController@getTipologiaByPuntaje');
        
        
        /***********************/
        
        Route::get('caracteristicasbloques', 'CaracteristicasBloqueController@showAll');
        Route::get('caracteristicasbloques/{id?}', 'CaracteristicasBloqueController@show');
        Route::get('caracteristicasbloqueportipos/{id?}', 'CaracteristicasBloqueController@caracteristicasbloqueportipo');

        Route::get('coeficientedepreciacion', 'CoeficienteDepreciacionController@showAll');
        Route::get('coeficientedepreciacion/{id?}', 'CoeficienteDepreciacionController@show');
        
        Route::get('coeficientetopograficos', 'CoeficienteTopograficoController@showAll');
        Route::get('coeficientestopograficos/{id?}', 'CoeficienteTopograficoController@show');
        
        Route::get('coeficientesusos', 'CoeficientesUsoController@showAll');
        Route::get('coeficientesusos/{id?}', 'CoeficientesUsoController@show');
        
        Route::get('datospropietarios', 'DatosPropietarioController@showAll');
        Route::get('datospropietarios/{id?}', 'DatosPropietarioController@show');
		Route::get('datospropietariopredio/{id?}', 'DatosPropietarioController@getPropietarioByPredio');
        Route::post('datospropietarios', 'DatosPropietarioController@store');
        Route::put('datospropietarios', 'DatosPropietarioController@update');
		Route::post('propietariosupdate', 'DatosPropietarioController@update');        

        Route::post('prediodatos', 'PredioDatoController@store');
        Route::put('prediodatos', 'PredioDatoController@update');
		Route::post('prediodatoUpdate', 'PredioDatoController@update');
        Route::post('prediodatosAndListIdService', 'PredioDatoController@storePredioDatoAndListIdService');
		Route::get('prediodatobypredio/{id?}', 'PredioDatoController@getPredioDatoByPredio');
        //Route::put('prediodatosAndListIdService', 'ValoresBloqueController@store');
        
        Route::post('valoresbloques', 'ValoresBloqueController@store');
        Route::get('listaValorBloquePorIdBloqueDato/{id?}', 'ValoresBloqueController@getListValorBloqueByIdBloqueDato');
        
        Route::get('formapredios', 'FormaPredioController@showAll');
        Route::get('formapredios/{id?}', 'FormaPredioController@show');  
        
        Route::get('materialvia', 'MaterialViumController@showAll');
        Route::get('materialvia/{id?}', 'MaterialViumController@show');  
                
        Route::get('servicios', 'ServicioController@showAll');
		Route::post('servicios', 'ServicioController@store');
		Route::post('updateservicios', 'ServicioController@update');
        Route::get('servicios/{id?}', 'ServicioController@show');
        Route::get('getListServiciosByIdPredio/{idPredio}', 'ServicioController@getListServiciosByIdPredio');
        
        
        Route::get('tipocaracteristicas', 'TipoCaracteristicasController@showAll');
        Route::get('tipocaracteristicas/{id?}', 'TipoCaracteristicasController@show');
        
        Route::get('tipomejoras', 'TipoMejoraController@showAll');
        
        Route::get('ubicacionpredios', 'UbicacionPredioController@showAll');
        Route::get('ubicacionpredios/{id?}', 'UbicacionPredioController@show');
        
        Route::get('zonahomogeneas', 'ZonaHomogeneaController@showAll');
        Route::get('zonahomogeneas/{id?}', 'ZonaHomogeneaController@show');

        Route::get('encriptarValor/{pass}', 'UserController@encriptarValor');
        
        Route::get('imagenCroquis/{idPredio}', 'ImagenPredioController@getURLCroquisByIdPredio');
        
        
        
        Route::post('/login', 'Api\AuthController@login');
        Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function() {
            Route::post('logout', 'Api\AuthController@logout');
            Route::post('sincronizarUsuario', 'UserController@sincronizarUsuario');
        });   


        //Agregado Ruddy
        Route::post('prediosUsuarioNroInmueble', 'PredioController@getListPredioByIdUsuarioAndNumeroInmuebleAndTipoUsuario');
        Route::post('prediosUsuarioNombresApellido', 'PredioController@getListPrediobyIdUsuarioAndNombreAndApellidoAndTipoUsuario');


        Route::post('prediosUsuario', 'PredioController@getListPredioByIdUsuario2');
		
		Route::post('migrarDatos', 'UserController@migrarDatosByIdUsuarioAndIdPredioFtp');


        Route::get('estadoAvaluo/{idPredio}', 'AvaluoController@getEstadoAvaluoByIdPredio');
        Route::get('nroFormularioAvaluo/{idPredio}', 'AvaluoController@getNroFormularioByIdPredio');

        Route::get('usuarioPredio/{idPredio}', 'UserController@getIdUsuarioByIdPredio');

        Route::post('migrarUsuario', 'UserController@migrarUsuario');

        //nuevas rutas para bloques nueva version
        Route::get('bloquesdatosmixbypredio/{id?}', 'BloquesDatoController@getListBloquesDatosMixByIdPredio');
        Route::get('bloquesdatosonlybypredio/{id?}', 'BloquesDatoController@getOnlyListBloquesDatosByIdPredio');
        Route::post('savebloquesdatosnew', 'BloquesDatoController@saveBloquesDatosNew');

});
