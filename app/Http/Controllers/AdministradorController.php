<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function getViewDashboard(){
        return view("admin-dashboard");
    }

    public function getViewProductos(){
        return view("admin-productos");
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
