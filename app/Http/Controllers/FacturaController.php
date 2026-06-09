<?php
// app/Http/Controllers/FacturaController.php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Configuracion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    public function generarFactura($pedidoId)
    {
        // Obtener el pedido con todas sus relaciones
        $pedido = Pedido::with(['usuario', 'direccion', 'detalles.producto', 'pago', 'envio'])
            ->findOrFail($pedidoId);
        
        // Verificar que el pedido pertenezca al usuario autenticado
        if ($pedido->id_usuario !== Auth::id()) {
            abort(403, 'No autorizado');
        }
        
        // Verificar que el pago esté completado
        if (!$pedido->pago || $pedido->pago->estado !== 'COMPLETED') {
            return back()->with('error', 'No se puede generar la factura porque el pago no está completado.');
        }
        
        // Obtener configuración de la empresa
        $configuracion = Configuracion::first();
        
        // Calcular IVA si está configurado
        $ivaPorcentaje = $configuracion ? $configuracion->iva : 0;
        $subtotal = $pedido->subtotal;
        $iva = $subtotal * ($ivaPorcentaje / 100);
        $total = $pedido->total;
        
        // Preparar datos para la vista
        $data = [
            'pedido' => $pedido,
            'configuracion' => $configuracion,
            'ivaPorcentaje' => $ivaPorcentaje,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'fechaEmision' => now(),
            'numeroFactura' => 'FAC-' . str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT)
        ];
        
        // Generar PDF
        $pdf = Pdf::loadView('factura-pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        // Descargar el PDF
        return $pdf->download('factura-' . $data['numeroFactura'] . '.pdf');
    }
}