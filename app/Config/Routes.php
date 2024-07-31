<?php

namespace Config;

use CodeIgniter\Config\Services;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);  // Deshabilitar el auto-routing por seguridad

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Ruta por defecto
$routes->get('/', 'Home::index');
$routes->get('login', 'AccountController::login');
$routes->post('login', 'AccountController::acceder');
$routes->post('salir', 'AccountController::salir');

// Intake
$routes->get('intake/(:segment)', 'IntakeController::index/$1');
$routes->post('intake/guardar', 'IntakeController::guardar');

// Encuestas
$routes->get('encuesta/(:segment)', 'EncuestaController::index/$1');
$routes->post('encuesta/guardarRespuestaEncuesta', 'EncuestaRespuestaController::guardarRespuestaEncuesta');

// Usuarios
$routes->group('usuarios', ['filter' => 'SessionAdmin:ADMIN'], function ($routes) {
    $routes->get('/', 'Usuarios::index', ['as' => 'usuarios.index']);
    $routes->get('obtener-usuarios', 'Usuarios::obtenerUsuarios', ['as' => 'usuarios.obtener']);
    $routes->get('obtener-usuario/(:num)', 'Usuarios::obtenerUsuarioPorId/$1');
    $routes->post('agregar-usuario', 'Usuarios::agregarUsuario', ['as' => 'usuarios.agregar']);
    $routes->post('editar-usuario', 'Usuarios::editarUsuario', ['as' => 'usuarios.editar']);
    $routes->post('borrar-usuario', 'Usuarios::borrarUsuario', ['as' => 'usuarios.borrar']);
});

// Sucursales
$routes->group('sucursales', ['filter' => 'SessionAdmin:ADMIN'], function ($routes) {
    $routes->get('/', 'Sucursales::index', ['as' => 'sucursales.index']);
    $routes->get('obtener-sucursales', 'Sucursales::obtenerSucursales', ['as' => 'sucursales.obtener']);
    $routes->post('agregar-sucursal', 'Sucursales::agregarSucursal', ['as' => 'sucursales.agregar']);
    $routes->post('editar-sucursal', 'Sucursales::editarSucursal', ['as' => 'sucursales.editar']);
    $routes->post('eliminar-sucursal', 'Sucursales::eliminarSucursal', ['as' => 'sucursales.eliminar']);
});

// Abogados
$routes->group('abogados', ['filter' => 'SessionAdmin:ADMIN,ATTORNEY'], function ($routes) {
    $routes->get('/', 'AbogadosController::index', ['as' => 'abogados.index']);
    $routes->get('obtener-abogados', 'AbogadosController::obtenerAbogados');
    $routes->post('agregar-abogado', 'AbogadosController::agregarAbogado', ['as' => 'abogados.agregar']);
    $routes->post('editar-abogado', 'AbogadosController::editarAbogado', ['as' => 'abogados.editar']);
    $routes->post('eliminar-abogado', 'AbogadosController::eliminarAbogado', ['as' => 'abogados.eliminar']);
});

// CLIENTES
$routes->group('clientes', ['filter' => 'SessionAdmin:ADMIN,PARALEGAL,ATTORNEY,RECEPTION,CALL'], function ($routes) {
    $routes->get('/', 'ClientesController::index', ['as' => 'clientes.index']);
    $routes->post('obtener-clientes', 'ClientesController::obtenerClientes'); // Modificado para soportar filtros
    $routes->post('agregar-cliente', 'ClientesController::insertarCliente');
    $routes->post('actualizar-estatus', 'ClientesController::actualizarEstatus');
    $routes->post('actualizarCliente', 'ClientesController::actualizarCliente');
    $routes->get('recepcion', 'ClientesController::recepcion');
    $routes->post('obtener-recepcion', 'ClientesController::obtenerClientesRecepcion');
    $routes->post('asignar-abogado', 'ClientesController::asignarAbogado');
    $routes->get('(:num)', 'ClientesController::verCliente/$1');
    $routes->post('casos-cliente', 'ClientesController::obtenerCasosPorCliente');
    $routes->post('clientid', 'ClientesController::actualizarClientID');
    $routes->get('abogado', 'ClientesController::abogado');
    $routes->get('obtener-abogado', 'ClientesController::obtenerClientesAbogado');
    $routes->post('nuevo-caso', 'ClientesController::nuevoCaso');
    $routes->get('asignados', 'ClientesController::clientesAsignados');
    $routes->get('asignados-obtener', 'ClientesController::obtenerClientesAsignados');
});

$routes->group('clientes', ['filter' => 'SessionAdmin:CALL'], function ($routes) {
    $routes->get('callcenter', 'ClientesController::callcenter');
    $routes->get('callcenter/obtener', 'ClientesController::obtenerClientesCallCenter');
    $routes->post('callcenter/agregar', 'ClientesController::insertarClienteCallCenter');
    $routes->get('callcenter/(:num)', 'ClientesController::verCliente/$1');
});

// Casos
$routes->group('casos', ['filter' => 'SessionAdmin:ADMIN,PARALEGAL,RECEPTION,ATTORNEY'], function ($routes) {
    $routes->post('actualizarCaseID', 'CasosController::actualizarCaseID');
    $routes->post('actualizar-estatus', 'CasosController::actualizarEstatus');
    $routes->post('comentarios', 'CasosController::obtenerComentarios');
    $routes->post('comentarios-agregar', 'CasosController::agregarComentario');
    $routes->post('editar', 'CasosController::editarCaso');
});

// Reportes
$routes->group('reportes', ['filter' => 'SessionAdmin:ADMIN,ATTORNEY'], function ($routes) {
    $routes->get('/', 'ReportesController::index');
    $routes->get('encuesta-respuesta', 'EncuestaRespuestaController::obtenerRegistros');
    $routes->get('encuesta-respuestas', 'EncuestaRespuestaController::obtenerTablaEncuestas');
    $routes->post('casos-por-tipo', 'ReportController::casosPorTipo');
    $routes->post('casos-por-estatus', 'ReportController::casosPorEstatus');
    $routes->post('casos-por-abogado', 'ReportController::casosPorAbogado');
    $routes->post('casos-por-sucursal', 'ReportController::casosPorSucursal');
    $routes->post('casos-pagados-vs-no-pagados', 'ReportController::casosPagadosVsNoPagados');
    $routes->post('clientes-por-sucursal', 'ReportController::clientesPorSucursal');
    $routes->post('clientes-por-estatus', 'ReportController::clientesPorEstatus');
    $routes->post('comentarios-por-caso', 'ReportController::comentariosPorCaso');
    $routes->post('encuestas-de-satisfaccion', 'ReportController::encuestasDeSatisfaccion');
    $routes->post('ingresos-por-tipo-de-caso', 'ReportController::ingresosPorTipoDeCaso');
    $routes->post('ingresos-por-sucursal', 'ReportController::ingresosPorSucursal');
});

//CUENTA
$routes->group('cuenta', ['filter' => 'SessionAdmin'], function ($routes) {
    $routes->get('/', 'CuentaController::index', ['as' => 'cuenta.index']);
    $routes->post('actualizar', 'CuentaController::actualizar', ['as' => 'cuenta.actualizar']);
});

//API
$routes->group('api', ['namespace' => '\App\Controllers'], function ($routes) {
    $routes->get('getToken', 'ApiController::getToken');
    $routes->get('getClientInfo/(:num)', 'ApiController::getClientInfo/$1');
    $routes->get('getClients', 'ApiController::getClients');
    $routes->post('addClient', 'ApiController::addClient');
    $routes->delete('deleteClient/(:num)', 'ApiController::deleteClient/$1');
    $routes->post('editClient/(:num)', 'ApiController::editClient/$1');
    $routes->get('(:alphanum)/getInvoices/(:num)', 'ApiController::getClientInvoices/$1/$2');
    $routes->post('createCase', 'ApiController::createCase/$1');
    $routes->post('addCaseParty/(:num)', 'ApiController::addCaseParty/$1');
    $routes->get('worldCountries', 'ApiController::getWorldCountries');
    $routes->get('lawFirmLocations', 'ApiController::getLawFirmLocations');
    $routes->get('caseProcesses', 'ApiController::getCaseProcesses');
    $routes->put('updateCustomField/(:num)/(:num)', 'ApiController::updateCustomField/$1/$2');
});

$routes->get('/buscar', 'BusquedaController::buscar');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
