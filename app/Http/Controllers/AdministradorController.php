<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Obtener configuración de PayPal (asumiendo que se identifica por tener correo)
        $paypalConfig = Configuracion::whereNotNull('correo')->first();
        
        // Obtener configuración de IVA (asumiendo que se identifica por tener valor en iva)
        $ivaConfig = Configuracion::whereNotNull('iva')->first();
        
        return view("admin-configuracion", compact('paypalConfig', 'ivaConfig'));
        //return view("admin-configuracion");
    }
    public function getViewEnvios(){
        return view("admin-gestion-envios");
    }

    // Para almacenar (POST)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paypal-email' => 'required|email',
            'paypal-name' => 'nullable|string',
        ]);
        Log::info("Cuenta correo",["Datos"=>$validated]);
        
        Configuracion::create([
            'correo' => $validated['paypal-email'],
            'nombreTitular' => $validated['paypal-name'],
        ]);
        
        return redirect()->back()->with('success', 'Configuración guardada correctamente');
    }

    // Para actualizar (PUT)
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'paypal-email' => 'required|email',
            'paypal-name' => 'required|nullable|string',
        ]);
        
        $config = Configuracion::findOrFail($id);
        $config->update([
            'correo' => $validated['paypal-email'],
            'nombreTitular' => $validated['paypal-name'],
        ]);
        
        return redirect()->back()->with('success', 'Configuración actualizada correctamente');
    }

    // Almacenar IVA (POST)
    public function storeIva(Request $request)
    {
        $validated = $request->validate([
            'iva-porcentaje' => 'required|numeric|min:0|max:100'
        ]);

        // Convertir el porcentaje a decimal con al menos dos decimales
        $ivaDecimal = round($validated['iva-porcentaje'] / 100, 2);
        
        Configuracion::create([
            'iva' => $ivaDecimal
        ]);
        
        return redirect()->back()->with('success', 'IVA guardado correctamente');
    }

    // Actualizar IVA (PUT)
    public function updateIva(Request $request, $id)
    {
        $validated = $request->validate([
            'iva-porcentaje' => 'required|numeric|min:0|max:100'
        ]);
        // Convertir el porcentaje a decimal con al menos dos decimales
        $ivaDecimal = round($validated['iva-porcentaje'] / 100, 2);

        $ivaConfig = Configuracion::findOrFail($id);
        $ivaConfig->update([
            'iva' => $ivaDecimal
        ]);
        
        return redirect()->back()->with('success', 'IVA actualizado correctamente');
    }

}
