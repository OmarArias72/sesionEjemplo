<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function getViewMiPerfil(){
        return view("user-dashboard");
    }

    public function getEditarPerfil(){
        return view("user-editar-perfil");
    }

    public function getEditarDireccion(){
        return view("user-editar-direccion");
    }

    public function getMisPedidos(){
        return view("user-mis-pedidos");
    }
}
