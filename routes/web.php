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
});

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

        Route::post('/crear-categorias', [CategoriaController::class,'createCategoriaView'])->name('categorias-crear');
        //VISTAS PARA PRODUCTOS

        Route::get('/productos', [AdministradorController::class,'getViewProductos'])->name('productos');

        Route::get('/crear-productos', [ProductoController::class,'getViewCrearProductos'])->name('productos.crear');

        Route::post('/registrar-productos', [ProductoController::class,'storeOrUpdate'])->name('productos.registrar');

        Route::get('/busqueda-productos', [ProductoController::class,'searchProducto'])->name('productos.buscar');

        Route::get('/pagos', [AdministradorController::class,'getViewPagos'])->name('pagos');

        Route::get('/pedidos', [AdministradorController::class,'getPedidos'])->name('pedidos');

        Route::get('/configuracion', [AdministradorController::class,'getViewConfiguracion'])->name('configuracion');
    });
// Panel de USUARIO ESTÁNDAR
Route::middleware(['auth','role:usuario_estandar'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UsuarioController::class,'getViewMiPerfil'])->name('dashboard-usuario'); // user.dashboard

        Route::get('/editar-perfil', [UsuarioController::class, 'getEditarPerfil'])->name('perfil');

        Route::get('/editar-direccion', [UsuarioController::class, 'getEditarDireccion'])->name('direccion');

        Route::get('/mis-pedidos', [UsuarioController::class, 'getMisPedidos'])->name('pedidos');
    });
require __DIR__.'/auth.php';
