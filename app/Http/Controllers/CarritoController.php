<?php

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
        //dd(get_class($usuario));
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
    public function agregar(Request $request){
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            "cantidad"=> 'required|integer|min:1'
        ]);
        $producto=Producto::findOrFail($request->id_producto);
        if ($producto->stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible');
        }
        //COMIENZO DE LA DEPURACION DE ERRORES
        //$usuario = Auth::user();
        //$claseUsuario = get_class($usuario);
        
        // Registramos en el log
        // Log::info('Clase del usuario durante agregar al carrito:', [
        //     'clase' => $claseUsuario,
        //     'id_producto' => $request->id_producto,
        //     'cantidad' => $request->cantidad,
        //     'metodos_clase'=>get_class_methods($usuario)
        // ]);
        
        // Mostramos en la respuesta (para depuración)
        //dd($claseUsuario);
        
        //FINALIZACION DE LA DEPURACION
        $carritoActivo=$this->obtenerCarritoActivo();
        // Verificar si el producto ya está en el carrito
        $itemExistente = $carritoActivo->productos()->where('carrito_productos.id_producto', $producto->id_producto)->first();

        if ($itemExistente) {
            // Actualizar cantidad
            $nuevaCantidad = $itemExistente->pivot->cantidad + $request->cantidad;
            $carritoActivo->productos()->updateExistingPivot($producto->id_producto, [
                'cantidad' => $nuevaCantidad
            ]);
        } else {
            // Añadir nuevo producto
            $carritoActivo->productos()->attach($producto->id_producto, [
                'cantidad' => $request->cantidad,
                'precio_unitario' => $producto->precio
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
        $ivaConfig=0;
        // Obtener el porcentaje de IVA de la configuración (en formato decimal, ej. 0.16)
        $ivaConfig = Configuracion::whereNotNull('iva')->first();
        $ivaFactor = $ivaConfig ? $ivaConfig->iva : 0.16; // Valor por defecto 0.16 si no existe
        
       $cartItems = collect();
        $subtotalSinIva = 0;
        $total = 0;
        $ivaTotal = 0;

        if ($cart) {
            // Obtener los productos del carrito con sus relaciones
            $cartItems = CarritoProducto::with('producto')
                ->where('id_carrito', $cart->id_carrito)
                ->get();

            // Calcular total con IVA incluido (suma directa de precios)
            $total = $cartItems->sum(function ($item) {
                return $item->precio_unitario * $item->cantidad;
            });
            
            // Calcular subtotal sin IVA (extraer el IVA de los precios)
            $subtotalSinIva = $cartItems->sum(function ($item) use ($ivaFactor) {
                $precioSinIva = $item->precio_unitario / (1 + $ivaFactor);
                return $precioSinIva * $item->cantidad;
            });
            
            // Calcular el monto total de IVA
            $ivaTotal = round($total - $subtotalSinIva,2);
        }

        return view('carrito', compact('cartItems', 'subtotalSinIva', 'ivaTotal', 'total'));
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
