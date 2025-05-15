<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Empresa;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
         // Obtener los pagos con sus relaciones y paginación
        $pagos = Pago::with(['pedido.usuario'])
        ->select([
            'pagos.id_pago as id_transaccion',
            'pagos.id_pedido',
            'pagos.metodoPago',
            'pagos.fechaPago',
            'pagos.montoPagado',
            'pagos.estado'
        ])
        ->orderBy('pagos.fechaPago', 'desc')
        ->paginate(8);

        // Transformar los datos para la vista
        $pagosTransformados = $pagos->getCollection()->map(function ($pago) {
            return [
                'id_transaccion' => $pago->id_transaccion,
                'numero_pedido' => $pago->pedido ? '#ORD-' . $pago->pedido->id_pedido : 'N/A',
                'nombre_cliente' => $pago->pedido && $pago->pedido->usuario 
                    ? $pago->pedido->usuario->nombre . ' ' . $pago->pedido->usuario->apellido 
                    : 'Cliente no disponible',
                'metodo_pago' => $pago->metodoPago,
                'fecha_pago' => $pago->fechaPago,
                'monto_pagado' => $pago->montoPagado,
                'estado' => $pago->estado
            ];
        });

        // Reemplazar la colección en el paginador
        $pagos->setCollection($pagosTransformados);

        return view("admin-pagos", ['pagos' => $pagos]);
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
    public function verPagosEnvios(){
        return view("admin-gestion-envios");
    }
    public function getViewEnvios(){
        $pedidos = Pedido::with([
            'usuario',
            'detalles.producto', // Cargar producto por si se requiere
            'pago'
        ])->orderBy('created_at', 'desc')->paginate(5);
            
        $empresas = Empresa::all(); // Obtener todas las empresas
        return view("admin-gestion-envios-tabla", compact("pedidos","empresas"));
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

    public function storeEmpresaEnvio(Request $request){
        $validator = Validator::make($request->all(), [
            "nueva-empresa"     => 'required|string|max:255',
            "nuevo-contacto"    => 'required|string|max:255',
            "contacto-empresa"  => 'required|string|email|max:255',
            "telefono-empresa"  => [
                'required',
                'string',
                'max:20',
                'regex:/^\+?[0-9\s\-]{7,20}$/'
            ]
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $validatedData = $validator->validated();
        Empresa::create([
            "nombreEmpresa"=>$validatedData["nueva-empresa"],
            "nombreContacto"=>$validatedData["nuevo-contacto"],
            "correo"=>$validatedData["contacto-empresa"],
            "numeroContacto"=>$validatedData["telefono-empresa"]
        ]);

        return redirect()->back()->with('success', 'Empresa registrada correctamente');
    }

}
