<?php

use App\cliente;
use App\detallePedido;
use App\listaMenu;
use App\menu;
use App\pedido;
use App\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('contenido.page');
});


Route::get('/index', function () {
    return view('contenido.contenido');
});


//----------CATEGORIA-------------////
Route::get('categoria','ctrlCategoria@index');
Route::post('categoria/guardar','ctrlCategoria@store');
Route::post('categoria/actualizar','ctrlCategoria@update');
Route::post('categoria/eliminar','ctrlCategoria@delete');
Route::get('/categoria/selectCategoria', 'ctrlCategoria@selectCategoria');



/////----------------Producto-----------------///
Route::get('producto','ctrlProducto@mostrar');
Route::post('producto/guardar','ctrlProducto@guardar');
Route::post('producto/modificar','ctrlProducto@modificar');
Route::post('producto/eliminar','ctrlProducto@eliminar');
Route::get('producto/buscarProducto','ctrlProducto@buscarProducto');
Route::get('producto/buscarProductoCategoria','ctrlProducto@buscarProductoCategoria');

Route::get('/producto/menu','ctrlProducto@productoMenu');
Route::get('/producto/selectProducto', 'ctrlProducto@selectProducto');
Route::get('/producto/menuProducto', 'ctrlProducto@menuProducto');
Route::get('/producto/listaMenuProducto', 'ctrlProducto@listaMenuProducto');




// /producto/listaMenuProducto?buscar='+ buscar + '&criterio='+ criterio

// Route::get('/producto/buscarProducto', 'ctrlProducto@buscarProducto');



/////----------------Mesa-----------------///
Route::get('mesa','ctrlMesa@mostrar');
Route::post('mesa/guardar','ctrlMesa@guardar');
Route::post('mesa/modificar','ctrlMesa@modificar');
Route::post('mesa/libre','ctrlMesa@libre');
Route::post('mesa/ocupado','ctrlMesa@ocupado');
Route::post('mesa/eliminar','ctrlMesa@eliminar');



/////----------------Rol-----------------///
Route::get('rol','ctrlRol@rolUser');

/////----------------Menú-----------------///
Route::get('menu','ctrlMenu@mostrar');
Route::post('menu/guardar','ctrlMenu@guardar');
Route::post('menu/activar','ctrlMenu@activar');
Route::post('menu/desactivar','ctrlMenu@desactivar');
Route::post('menu/eliminar','ctrlMenu@eliminarMenu');
Route::get('menu/allMenu','ctrlMenu@allMenus');



/////----------------Cliente-----------------///
Route::get('cliente','ctrlCliente@index');
Route::post('cliente/guardar','ctrlCliente@store');
Route::post('cliente/actualizar','ctrlCliente@update');
Route::post('cliente/activar','ctrlCliente@activar');
Route::post('cliente/desactivar','ctrlCliente@desactivar');
Route::post('cliente/eliminar','ctrlCliente@delete');
Route::get('/cliente/selectCliente','ctrlCliente@selectCliente'); 
Route::get('/cliente/dato','ctrlCliente@datoUser'); 

/////----------------Usuario-----------------///
Route::get('usuario','ctrlUsuario@index');
Route::post('usuario/guardar','ctrlUsuario@guardar');


/////---------------Orden---------------------------- ///////
Route::post('/ordenAtencion/guardar', 'ctrlOrdenAtencion@guardar');
Route::get('detalleOrden/buscar','ctrlOrdenAtencion@buscarDetalle');
Route::post('detalleOrden/modificar','ctrlOrdenAtencion@modificarDetalle');
Route::post('/finalizar/orden','ctrlOrdenAtencion@finalizarOrden');


//Pedidos
Route::post('/pedido/store','ctrlPedido@guardar')->name('pedido.store');

/////----------------Pedido Cliente-----------------///
Route::get('pedido/cliente','ctrlPedido@mostrarPedidoCliente');
Route::get('pedido/admin','ctrlPedido@mostrarPedidoAdmin');
Route::get('pedidoRepartidor','ctrlPedido@mostrarPedidoRepartidor');



Route::post('pedido/entregado','ctrlPedido@entregado');
Route::get('/detalle/pedido/cliente','ctrlPedido@mostrarDetallePedidoCliente');
Route::get('/detalle/pedido/admin','ctrlPedido@mostrarDetallePedidoAdmin');
Route::get('/detalle/pedido/repartidor','ctrlPedido@mostrarDetallePedidoRepartidor');




// pedido/entregado

Route::post('/item/eliminar','ctrlOrdenAtencion@itemEliminar');
Route::post('/item/actualizar','ctrlOrdenAtencion@itemActualizar');



//////------------------Detalle-----------------------------///////
Route::post('/agregar/producto/detalle','ctrlOrdenAtencion@agregarProductoDetalle');
Route::get('/orden','ctrlOrdenAtencion@mostrarOrdenes');
Route::get('/detalle/orden','ctrlOrdenAtencion@mostrarDetalleOrden');
// '/detalle/'+ id


Route::get('/pdf/orden/{id}','ctrlPDF@generarPDFOrden')->name('orden.pdf');

Route::get('/pdf/pedido/{id}','ctrlPDF@generarPDFPedido')->name('pedido.pdf');


/////----------------Repartidor-----------------///
Route::get('repartidor','ctrlRepartidor@index');
Route::post('repartidor/guardar','ctrlRepartidor@store');
Route::post('repartidor/actualizar','ctrlRepartidor@update');
Route::post('repartidor/eliminar','ctrlRepartidor@delete');
Route::get('/repartidor/selectRepartidor', 'ctrlRepartidor@selectRepartidor');
Route::get('/pedido/repartidor', 'ctrlRepartidor@agregarRepartidor');
Route::post('repartidor/agregar','ctrlRepartidor@guardarRepartidor');

// '/agregar/repartidor'


/////----------------Tipo-----------------///
Route::get('tipo','ctrlTipo@index');
Route::post('tipo/guardar','ctrlTipo@store');
Route::put('tipo/actualizar','ctrlTipo@update');
Route::put('tipo/eliminar','ctrlTipo@delete');

/////----------------Vehiculo-----------------///
Route::get('vehiculo','ctrlVehiculo@mostrar');
Route::post('vehiculo/guardar','ctrlVehiculo@guardar');
Route::post('vehiculo/modificar','ctrlVehiculo@modificar');
Route::post('vehiculo/eliminar','ctrlVehiculo@eliminar');

//------------------reserva----------------//

Route::get('reserva'           ,'ctrlReserva@mostrar');
Route::post('reserva/guardar'  ,'ctrlReserva@guardar');
Route::post('reserva/modificar','ctrlReserva@modificar');
Route::post('reserva/eliminar' ,'ctrlReserva@eliminar');

Route::get('reservaCliente','ctrlReserva@mostrarReservaCliente');
Route::post('reserva/cliente/guardar','ctrlReserva@guardarReservaCliente');
Route::post('reserva/cliente/modificar','ctrlReserva@modificarReservaCliente');

//------pedido---//

Route::get('pedido'           ,'ctrlPedido@mostrar');

Route::post('pedido/cancelado','ctrlPedido@estadoCancelado');
Route::post('pedido/pendiente','ctrlPedido@estadoPendiente');
Route::post('pedido/entregado/admin','ctrlPedido@estadoEntregado');

//------------------reserva admin----------------//
Route::post('reserva/cancelada','ctrlReserva@reservacancelada');
Route::post('reserva/pendiente','ctrlReserva@reservapendiente');


//   Usuario
Route::get('/usuario/autenticado', 'ctrlUsuario@authenticado' );


Route::get('bitacora','ctrlBitacora@mostrar');



Route::get('prueba', function () {
    return view('prueba');
    });




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
