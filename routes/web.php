<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Models\CategoriaMasDestacada;
use App\Models\ProductoMasVendido;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
        // Obtener categorías destacadas con el producto más vendido de cada una
        $categoriasDestacadas = CategoriaMasDestacada::all();
        //Log::info("Productos de categorias destacadas",["Productos"=>$categoriasDestacadas]);
        $productosMasVendidos = ProductoMasVendido::all();
        
        return view('index', compact('categoriasDestacadas', 'productosMasVendidos'));
    //return view('index');
})->name("home");

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'role:administrador'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin-dashboard');
//     })->name('admin-dashboard');
// });
// Panel de ADMINISTRADOR
Route::middleware(['auth', 'role:administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdministradorController::class,'getViewDashboard'])->name('dashboard-admin'); // admin.dashboard

        //VISTA PARA EL PANEL DE ENVIOS
        Route::get('/envios', [AdministradorController::class,'verPagosEnvios'])->name('envios');
        Route::get('envios/pedidos/estatus',[AdministradorController::class, 'getViewEnvios'])->name('envios.tabla');
        Route::post('/envios/usuario/pedido',[EnvioController::class,'store'])->name('store.envio');
        Route::get('/lista/envios/asignados',[EnvioController::class,'obtenerEnvios'])->name("lista.envios-asignados");
        Route::put('/actualizar/pedido/envio',[EnvioController::class,'update'])->name("pedido-envio.actualizar");
        Route::get("/gestion-envios/estado/envios",[EnvioController::class,'listaEnvios'])->name("envios-lista.estado");
        //VISTAS CATEGORIAS
        Route::get('/categorias', [CategoriaController::class,'createCategoriaView'])->name('categorias');

        Route::post('/crear-categorias', [CategoriaController::class,'store'])->name('categorias-crear');
        //VISTAS PARA PRODUCTOS

        Route::get('/productos', [AdministradorController::class,'getViewProductos'])->name('productos');
        Route::get('/admin/productos/tabla', [AdministradorController::class, 'tablaProductos'])->name('productos.tabla');

        Route::get('/crear-productos', [ProductoController::class,'getViewCrearProductos'])->name('productos.crear');

        Route::post('/registrar-productos', [ProductoController::class,'store'])->name('productos.registrar');

        Route::get('/productos/editar',[ProductoController::class,'createEditView'])->name("editar-producto");

        Route::put('/productos/producto/actualizar',[ProductoController::class,'update'])->name("actualizar-producto");

        Route::get("/buscar/producto",[ProductoController::class,"buscarProductoEditForm"])->name("buscar-producto");

        Route::get('/admin/productos/filtrados', [ProductoController::class, 'tablaProductosFiltrados'])->name('productos.tabla.filtrados');
        //RUTAS PARA PAGOS

        Route::get('/pagos', [AdministradorController::class,'getViewPagos'])->name('pagos');
        Route::get('/admin/pagos', [AdministradorController::class, 'getPagosFiltrados'])->name('pagos-filtrar');

        //RUTAS PARA PEDIDOS
        Route::get('/pedidos', [AdministradorController::class,'getPedidos'])->name('pedidos');
        Route::get('/admin/pedidos', [PedidoController::class, 'getPedidos'])->name('pedidos-filtrados');

        //RUTA PARA REGISTRA EMPRESA ENVIO
        Route::post("/empresa-envio/registrar",[AdministradorController::class,'storeEmpresaEnvio'])->name("empresa.store");
        //RUTAS PARA LA CONFIGURACION
        Route::get('/configuracion', [AdministradorController::class,'getViewConfiguracion'])->name('configuracion');

        Route::post('/configuracion', [AdministradorController::class, 'store'])->name('configuracion.store');
        Route::put('/configuracion/{id}', [AdministradorController::class, 'update'])->name('configuracion.update');
    
        Route::post('/configuracion/iva', [AdministradorController::class, 'storeIva'])->name('configuracion.iva.store');
        Route::put('/configuracion/iva/{id}', [AdministradorController::class, 'updateIva'])->name('configuracion.iva.update');
    });
// Panel de USUARIO ESTÁNDAR
Route::middleware(['auth','role:usuario_estandar'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UsuarioController::class,'getViewMiPerfil'])->name('dashboard-usuario'); // user.dashboard

        Route::get('/editar-perfil', [UsuarioController::class, 'getEditarPerfil'])->name('perfil');

        Route::put("actualizar-perfil",[UsuarioController::class,'updatePerfil'])->name("perfil-actualizar");

        Route::get('/editar-direccion', [UsuarioController::class, 'getEditarDireccion'])->name('direccion');

        Route::put("actualizar-direccion",[UsuarioController::class,'updateDireccion'])->name("direccion-actualizar");

        //RUTAS PARA PEDIDOS
        Route::post("/pedido/procesar",[PedidoController::class,'crearPedido'])->name("crear.pedido");
        Route::get('/pedido/estatus',[PedidoController::class,'success'])->name("success");
        Route::get('/pedido/estatus/actualizar',[PedidoController::class,'updatePayment'])->name("update-payment");
        Route::get('/pedido/cancelado',[PedidoController::class,'failed'])->name("cancel");
        Route::get('/mis-pedidos', [UsuarioController::class, 'getMisPedidos'])->name('pedidos');
        Route::get('/pedido/detalles/{pedidoId}',[UsuarioController::class,'detallePedido'])->name("pedidos-detalles")->where('numeroPedido', '.*');
        //RUTA PARA EL CARRITO
        Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
        Route::get('/carrito', [CarritoController::class, 'verCarrito'])->name('carrito.ver');
        Route::put('/carrito/{id}', [CarritoController::class, 'actualizar'])->name('carrito.update');
        Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.remove');
        Route::put('/cancelar/pedido/{id_pedido}',[PedidoController::class,'cancelarPedido'])->name("cancelar-pedido");
        Route::post('/pedido/{id_pedido}/generar-pago-nuevamente', [PedidoController::class, 'generarPagoNuevamente'])->name('generar-pago-nuevamente');

        //RUTA PARA DESCARGAR PDF
        Route::get('/factura/{pedidoId}', [FacturaController::class, 'generarFactura'])
            ->name('factura')
            ->where('pedidoId', '[0-9]+');
    });

//RUTAS PARA VER PRODUCTOS
// Ruta para la búsqueda y listado de productos
Route::get('/productos', [ProductoController::class, 'busquedaProducto'])->name('productos.search');
Route::get('/productos/filtrados', [ProductoController::class, 'buscarProductosFiltros'])->name('productos.filtrados');

// Ruta para ver detalles de un producto
Route::get('/productos/{id}', [ProductoController::class, 'mostrarDetallesProducto'])->name('productos.show');

require __DIR__.'/auth.php';
