<?php
// app/Http/Controllers/CarritoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\CarritoProducto;
use App\Models\Configuracion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    public function obtenerCarritoActivo(){
        
        $usuario = Auth::user();
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Usar la relación hasOne definida en el modelo Usuario
        $carrito = $usuario->carrito()->firstOrCreate([
            'estado' => 'activo'
        ], [
            'id_usuario' => $usuario->id_usuario,
            'estado' => 'activo'
        ]);

        return $carrito;
    }

    public function agregar(Request $request) {
        // Validación básica del ID del producto
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto'
        ]);
        
        // Determinar la cantidad (1 por defecto si no se envía)
        $cantidad = $request->has('cantidad') ? $request->cantidad : 1;
        
        // Validar que la cantidad sea válida si se envió
        if ($request->has('cantidad')) {
            $request->validate([
                'cantidad' => 'integer|min:1'
            ]);
        }
        
        $producto = Producto::findOrFail($request->id_producto);
        
        // Verificar stock disponible
        if ($producto->stock < $cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible');
        }
        
        $carritoActivo = $this->obtenerCarritoActivo();
        
        // Verificar si el producto ya está en el carrito
        $itemExistente = $carritoActivo->productos()
            ->where('carrito_productos.id_producto', $producto->id_producto)
            ->first();

        if ($itemExistente) {
            // Actualizar cantidad
            $nuevaCantidad = $itemExistente->pivot->cantidad + $cantidad;
            $carritoActivo->productos()->updateExistingPivot($producto->id_producto, [
                'cantidad' => $nuevaCantidad
            ]);
        } else {
            // Añadir nuevo producto (el precio ya incluye IVA desde la base de datos)
            $carritoActivo->productos()->attach($producto->id_producto, [
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio // Este precio YA incluye IVA
            ]);
        }

        return back()->with('success', 'Producto añadido al carrito');
    }

    public function verCarrito()
    {
        // Obtener el carrito activo del usuario autenticado
        $user = Auth::user();
        $cart = Carrito::where('id_usuario', $user->id_usuario)
                      ->where('estado', 'activo')
                      ->first();
        
        // Obtener el porcentaje de IVA de la configuración
        $ivaConfig = Configuracion::whereNotNull('iva')->first();
        $ivaFactor = $ivaConfig ? floatval($ivaConfig->iva) : 0.16; // Valor por defecto 0.16 si no existe
        
        $cartItems = collect();
        $subtotalConIva = 0;  // Subtotal con IVA incluido
        $ivaTotal = 0;        // Monto del IVA
        $subtotalSinIva = 0;  // Subtotal sin IVA
        $total = 0;           // Total final (igual al subtotal con IVA + envío)

        if ($cart) {
            // Obtener los productos del carrito con sus relaciones
            $cartItems = CarritoProducto::with('producto')
                ->where('id_carrito', $cart->id_carrito)
                ->get();

            // Calcular subtotal con IVA incluido (suma directa de precios que ya incluyen IVA)
            $subtotalConIva = $cartItems->sum(function ($item) {
                return $item->precio_unitario * $item->cantidad;
            });
            
            // Calcular el subtotal sin IVA (extrayendo el IVA del precio)
            $subtotalSinIva = $cartItems->sum(function ($item) use ($ivaFactor) {
                // Como el precio_unitario ya incluye IVA, dividimos entre (1 + IVA)
                $precioSinIva = $item->precio_unitario / (1 + $ivaFactor);
                return $precioSinIva * $item->cantidad;
            });
            
            // Calcular el monto total de IVA (diferencia entre subtotal con y sin IVA)
            $ivaTotal = round($subtotalConIva - $subtotalSinIva, 2);
            
            // El total final es el subtotal con IVA (más envío si aplica)
            $total = $subtotalConIva;
        }

        return view('carrito', compact(
            'cartItems', 
            'subtotalConIva',
            'subtotalSinIva', 
            'ivaTotal', 
            'total',
            'ivaFactor'
        ));
    }

    // Actualizar cantidad
    public function actualizar(Request $request, $id)
    {
        $item = CarritoProducto::findOrFail($id);
        $action = $request->input('action');
        $quantity = $request->input('quantity');

        if ($action === 'increase') {
            // Validar que no se supere el stock disponible
            if ($item->cantidad >= $item->producto->stock) {
                return redirect()->route('cart.show')
                            ->with('error', 'No hay suficiente stock disponible para este producto');
            }
            $item->cantidad += 1;
        } elseif ($action === 'decrease') {
            $item->cantidad = max(1, $item->cantidad - 1);
        } else {
            // Validar cantidad directa
            $newQuantity = max(1, $quantity);
            if ($newQuantity > $item->producto->stock) {
                return redirect()->route('cart.show')
                            ->with('error', 'La cantidad solicitada supera el stock disponible');
            }
            $item->cantidad = $newQuantity;
        }
        
        $item->save();
        
        return back()->with('success', 'Carrito actualizado');
    }

    // Eliminar producto del carrito
    public function eliminar($id)
    {
        $item = CarritoProducto::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Producto eliminado del carrito');
    }
}