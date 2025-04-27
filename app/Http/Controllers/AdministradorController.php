<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function getViewDashboard(){
        return view("admin-dashboard");
    }

    public function getViewProductos(){
        return view("admin-productos");
    }
    public function tablaProductos()
    {
        $productos = Producto::with('categorias')->paginate(3);
        return view('admin-productos-tabla', compact('productos'));
    }


    public function getViewPagos(){
        return view("admin-pagos");
    }

    public function getPedidos(){
        return view("admin-pedidos");
    }
    public function getViewConfiguracion(){
        return view("admin-configuracion");
    }
    public function getViewEnvios(){
        return view("admin-gestion-envios");
    }

    

}
