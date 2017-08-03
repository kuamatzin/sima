<?php

use App\Invitacion;
use App\Procedimiento;
use App\Proveedor;
use App\Services\ExcelGenerator;
use App\Services\NumerosLetras;

Route::get('/', ['middleware' => 'auth', function()
{
    return redirect('/home');
}]);

Route::get('/ganadores', function(){
    $proveedores = Proveedor::all();
    $ofertas_ganadoras = array();
    $letras = new NumerosLetras;
    foreach ($proveedores as $key => $proveedor) {
        if (sizeof($proveedor->ofertas->where('ganador', 1)) > 0) {
            $datos = array();
            $datos['proveedor'] = $proveedor->nombre;
            $datos['monto_total_adjudicado'] = $proveedor->ofertas->where('ganador', 1)->sum('monto_total');
            array_push($ofertas_ganadoras, $datos);
        }
    }
    return view('reportes.adjudicados', compact('ofertas_ganadoras'));
});

Route::get('/home', function(){
    if (Auth::user()->privilegios == 1) {
        return redirect('/procedimientos');
    }
    else if (Auth::user()->privilegios == 2) {
        return redirect('/procedimientos');
    }
    else if (Auth::user()->privilegios == 3) { 
        return redirect('/requisiciones');
    }
    else if (Auth::user()->privilegios == 4) {
        return redirect('/requisiciones');
    }
    else if (Auth::user()->privilegios == 5) {
        return redirect('/procedimientos');
    }
    else {
        return redirect('/auth/logout');
    }
});

//Analistas routes
Route::get('/analista', 'ProcedimientosAnalistaController@index');
Route::get('/analista/{procedimiento_id}', 'ProcedimientosAnalistaController@administrar');

Route::get('/proveedoresSistema', 'HomeController@index');

//Requisiciones routes
Route::get('requisiciones/descarga/{requisicion_id}', 'RequisicionesController@descarga');
Route::post('requisiciones/duplicate/{requisicion_id}', 'RequisicionesController@duplicate');
Route::resource('requisiciones', 'RequisicionesController');

//Dependecias routes
Route::resource('dependencias', 'DependenciasController');

//Unidades Administrativas routes
Route::get('unidades_administrativas/{dependencia_id}/create', 'UnidadesAdministrativasController@create');
Route::post('unidades_administrativas/{dependencia_id}', 'UnidadesAdministrativasController@store');
Route::resource('unidades_administrativas', 'UnidadesAdministrativasController');

//Usuarios para dependencias
Route::get('usuarios_dependecia/{user_id}/create', 'UsuariosController@dependencia_create');
Route::post('usuarios_dependecia/{user_id}', 'UsuariosController@dependencia_store');
Route::get('usuarios_dependecia/{user_id}/edit', 'UsuariosController@dependencia_edit');
Route::patch('usuarios_dependecia/{user_id}', 'UsuariosController@dependencia_update');

//Usuarios para procedimientos
Route::get('usuarios_procedimientos', 'UsuariosController@procedimientos');
Route::get('usuarios_procedimientos/create', 'UsuariosController@procedimientos_create');
Route::post('usuarios_procedimientos', 'UsuariosController@procedimientos_store');
Route::get('usuarios_procedimientos/{user_id}/edit', 'UsuariosController@procedimientos_edit');
Route::patch('usuarios_procedimientos/{user_id}', 'UsuariosController@procedimientos_update');

//Usuarios para unidades administrativas
Route::get('usuarios_unidad_administrativa/{user_id}/create', 'UsuariosController@unidad_administrativa_create');
Route::post('usuarios_unidad_administrativa/{user_id}', 'UsuariosController@unidad_administrativa_store');
Route::get('usuarios_unidad_administrativa/{user_id}/edit', 'UsuariosController@unidad_administrativa_edit');
Route::patch('usuarios_unidad_administrativa/{user_id}', 'UsuariosController@unidad_administrativa_update');

//Programa Anual routes
Route::post('programa_anual/duplicar/{programa_anual_id}', 'ProgramaAnualController@duplicar');
Route::get('programa_anual/descarga/{programa_anual_id}/{formato}', 'ProgramaAnualController@descarga');
Route::resource('programa_anual', 'ProgramaAnualController');

//Usuarios routes
Route::resource('usuarios', 'UsuariosController');

//Procedimientos routes
Route::resource('procedimientos', 'ProcedimientosController');
Route::post('/cancelar_prodecimiento/{procedimiento_id}', 'ProcedimientosController@cancelar_prodecimiento');
Route::get('/procedimiento/cancelado/{procedimiento_id}', 'ProcedimientosController@cancelado');

//Proveedores routes
Route::get('/cotizacion/{url}', 'ProveedoresController@cotizacion');
Route::get('/reabrirCotizacion/{invitacion}', 'ProveedoresController@reabrirCotizacion');
Route::post('/cotizacion/{invitacion_id}', 'ProveedoresController@cotizacionAction');
Route::post('/descargarCotizacionProveedor/{invitacion_id}', 'ProveedoresController@cotizacionFormato');
Route::get('/cotizacionBlanco/{proveedor_id}', 'ProveedoresController@invitacionBlanco');
Route::resource('proveedores', 'ProveedoresController');

Route::get('/lici/{procedimiento_id}', function($id){
    $invitacion = Invitacion::where('procedimiento_id', $id);
    $procedimiento = Procedimiento::findOrFail($id);
    $proveedores = $procedimiento->proveedoresInvitados();
});


//Agregar licitantes routes
Route::get('/licitantes/{procedimiento_id}', 'ProcedimientosController@licitantes');
Route::post('/licitantes/{procedimiento_id}', 'ProcedimientosController@licitantesStore');

//Ofertas routes
Route::get('invitacion/{procedimiento_id}', 'OfertasController@invitacion');
Route::post('invitacion/{procedimiento_id}', 'OfertasController@sendInvitacion');
Route::get('proveedores_invitados/{procedimiento_id}', 'OfertasController@proveedoresInvitados');
Route::get('descargaListaInvitaciones/{procedimiento_id}', 'OfertasController@descargaListaInvitaciones');
Route::get('verCotizacion/{invitacion_id}', 'OfertasController@verCotizacion');
Route::get('cerrarInvitacion/{procedimiento_id}', 'OfertasController@cerrarInvitacion');
Route::get('abrirInvitacion/{procedimiento_id}', 'OfertasController@abrirInvitacion');
Route::get('generarInvitacion/{procedimiento_id}', 'OfertasController@generateInvitacion');
Route::get('carga_economica/{procedimiento_id}', 'OfertasController@createCargaEconomica');
Route::post('carga_economica/{procedimiento_id}', 'OfertasController@storeCargaEconomica');
Route::post('carga_economica_finalizar/{procedimiento_id}', 'OfertasController@finalizarCargaEconomica');
Route::get('dictamen_tecnico/{procedimiento_id}', 'OfertasController@dictamen_tecnico');
Route::get('crear_dictamen_tecnico/{procedimiento_id}', 'OfertasController@crear_dictamen_tecnico');
Route::post('dictamen_tecnico/{procedimiento_id}', 'OfertasController@dictamen_tecnico_store');
Route::get('analisis_comparativo/{procedimiento_id}/{descarga}', 'OfertasController@analisis_comparativo');
Route::post('analisis_comparativo/{procedimiento_id}', 'OfertasController@analisis_comparativo_mantenimiento');
Route::get('descargaCuadroComparativo/{procedimiento_id}/{descarga}', 'OfertasController@analisis_comparativo');
Route::get('pedido/{procedimiento_id}', 'OfertasController@pedido');
Route::get('pedido/{procedimiento_id}/{proveedor_id}/{numero_pedido}', 'OfertasController@pedido_reporte');

//Partidas Presupuestales routes, all the routes recieve as parameter programa anual id, except show.

Route::get('partidas_presupuestales/{id_programa_anual}', 'PartidasPresupuestalesController@index');
Route::get('partidas_presupuestales/show/{id_partida_presupuesta}', 'PartidasPresupuestalesController@show');
Route::get('partidas_presupuestales/{id_programa_anual}/create', 'PartidasPresupuestalesController@create');
Route::post('partidas_presupuestales/{id_programa_anual}', 'PartidasPresupuestalesController@store');
Route::get('partidas_presupuestales/edit/{partida_presupuestal_id}', 'PartidasPresupuestalesController@edit');
Route::patch('partidas_presupuestales/{partida_presupuestal_id}', 'PartidasPresupuestalesController@update');
Route::delete('partidas_presupuestales/{partida_presupuestal_id}', 'PartidasPresupuestalesController@destroy');

//Partidas routes, all the routes recieve as parameter id requisicion, except show.

Route::get('partidas_programa_anual/{programa_anual_id}', 'PartidaProgramaAnualController@index');
Route::get('partidas_programa_anual/show/{partida_id}', 'PartidaProgramaAnualController@show');
Route::get('partidas_programa_anual/{programa_anual_id}/create', 'PartidaProgramaAnualController@create');
Route::post('partidas_programa_anual/{programa_anual_id}', 'PartidaProgramaAnualController@store');
Route::get('partidas_programa_anual/edit/{partida_id}', 'PartidaProgramaAnualController@edit');
Route::patch('partidas_programa_anual/{partida_id}', 'PartidaProgramaAnualController@update');
Route::delete('partidas_programa_anual/{partida_id}', 'PartidaProgramaAnualController@destroy');

//Partidas routes, all the routes recieve as parameter id requisicion, except show.

Route::get('partidas/{id_requisicion}', 'PartidasController@index');
Route::get('partidas/show/{id_partida}', 'PartidasController@show');
Route::get('partidas/{id_requisicion}/create', 'PartidasController@create');
Route::post('partidas/{id_requisicion}', 'PartidasController@store');
Route::get('partidas/edit/{id_partida}', 'PartidasController@edit');
Route::patch('partidas/{id_requisicion}/{id_partida}', 'PartidasController@update');
Route::delete('partidas/{id_requisicion}/{id_partida}', 'PartidasController@destroy');


//Facturas routes
Route::get('facturas/{oferta_id}', 'FacturasController@index');
Route::get('facturas/{oferta_id}/create', 'FacturasController@create');
Route::post('facturas/{oferta_id}', 'FacturasController@store');
Route::get('facturas/{factura_id}/edit', 'FacturasController@edit');
Route::patch('facturas/{factura_id}', 'FacturasController@update');
Route::delete('facturas/{factura_id}', 'FacturasController@destroy');

//Reportes routes
Route::get('/reportes_procedimientos', 'ReportesController@index');
Route::get('reportes/busqueda', 'ReportesController@busqueda');
Route::get('reportes/requisiciones/{anio}', 'ReportesController@requisiciones');
Route::get('/reportes/descargar', 'ReportesController@descargar');
Route::get('reportes/busqueda_por_procedimiento', 'ReportesController@busqueda_por_procedimiento');

//Route ajsutar cantidades
Route::get('ajustar_cantidades/{procedimiento_id}', 'PartidasController@ajustar');
Route::post('ajustar_cantidades/{procedimiento_id}', 'PartidasController@storeAjuste');
Auth::routes();
