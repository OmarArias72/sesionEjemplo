<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('index');
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

        Route::get('/envios', [AdministradorController::class,'getViewEnvios'])->name('envios');

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

        //RUTAS PARA PAGOS

        Route::get('/pagos', [AdministradorController::class,'getViewPagos'])->name('pagos');

        Route::get('/pedidos', [AdministradorController::class,'getPedidos'])->name('pedidos');

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

        Route::get('/mis-pedidos', [UsuarioController::class, 'getMisPedidos'])->name('pedidos');
    });
require __DIR__.'/auth.php';
