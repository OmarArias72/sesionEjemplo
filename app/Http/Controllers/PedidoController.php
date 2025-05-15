<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Configuracion;
use App\Models\DetallePedido;
use App\Models\Pago;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PedidoController extends Controller
{
    public function crearPedido(){
        // Obtener el carrito activo del usuario
        $usuario = auth()->user();
        //Log::info("Usuario",["nombre",$usuario->nombre]);
        $direccion = $usuario->direccion;
        //Log::info("Usuario",["direccion",$direccion->calle]);
        $carrito = Carrito::where('id_usuario',  $usuario->id_usuario)
                         ->where('estado', 'activo')
                         ->first();

        if (!$carrito) {
            return redirect()->back()->with('error', 'No se encontró un carrito activo');
        }

        // Verificar que el carrito tenga productos
        if ($carrito->productos->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        if (!$direccion) {
            return redirect()->back()->with('error', 'Debes tener una dirección registrada');
        }

        // Iniciar transacción para asegurar la integridad de los datos
        DB::beginTransaction();

        try {
            $ivaConfig = Configuracion::whereNotNull('iva')->first();
            $ivaFactor = $ivaConfig ? $ivaConfig->iva : 0.16; // Valor por defecto 0.16 si no existe
            // Calcular subtotal y total
            $total = $carrito->productos->sum(function($producto) {
                return $producto->pivot->precio_unitario * $producto->pivot->cantidad;
            });

            $subtotal = $carrito->productos->sum(function($producto) use ($ivaFactor) {
                $precioSinIva=$producto->pivot->precio_unitario/(1 + $ivaFactor);
                return $precioSinIva * $producto->pivot->cantidad;
            });
            Log::info("Calculos",["total"=>$total,"subtotal"=>$subtotal]);
            // Crear el pedido
            $pedido = Pedido::create([
                'id_usuario' =>  $usuario->id_usuario,
                'subtotal' => $subtotal,
                'total' => $total, // Aquí podrías agregar impuestos o descuentos
                'estado' => 'pendiente',
                'id_direccion'=>$direccion->id_direccion
            ]);

            // Crear los detalles del pedido
            foreach ($carrito->productos as $producto) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $producto->pivot->cantidad,
                    'precioUnitario' => $producto->pivot->precio_unitario
                ]);

                // Actualizar el stock del producto (opcional)
                $producto->stock -= $producto->pivot->cantidad;
                $producto->save();
            }

            // Cambiar el estado del carrito a "completado"
            $carrito->estado = 'completado';
            $carrito->save();

            DB::commit();
            // session()->put('id_carrito', $carrito->id_carrito);
            session()->put('pedido_id', $pedido->id_pedido);
            return $this->generarPago($pedido, $carrito->productos);

            // return redirect()->back()
            //                 ->with('success', 'Pedido creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('user.carrito.ver')
                            ->with('error', 'Ocurrió un error al procesar el pedido: ' . $e->getMessage());
        }
    
    }

    public function generarPago(Pedido $pedido, $productos){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $purchase_units = [];
        $total_value = 0;

        foreach ($productos as $producto) {
            $purchase_units[] = [
                'name' => $producto->nombre_producto,
                'description' => $producto->descripcion,
                'quantity' => $producto->pivot->cantidad,
                'unit_amount' => [
                    'currency_code' => 'MXN', // Cambia esto a la moneda que uses
                    'value' => number_format($producto->pivot->precio_unitario, 2, '.', '')
                ],
            ];
            $total_value += $producto->pivot->precio_unitario * $producto->pivot->cantidad;
        }

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'MXN', // Asegúrate de que coincida con la moneda de tus productos
                        'value' => number_format($total_value, 2, '.', ''),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'MXN',
                                'value' => number_format($total_value, 2, '.', '')
                            ],
                            'items' => $purchase_units,
                        ],
                    ],
                    'description' => 'Pedido #' . $pedido->id_pedido, // Descripción del pedido
                ],
            ],
            'application_context' => [
                'return_url' => route('user.success'),
                'cancel_url' => route('user.cancel'),
            ],
        ];

        try {
            $order = $provider->createOrder($data);
            //dd($order); // Para depuración, puedes ver la respuesta de PayPal
            // Aquí deberías redirigir al usuario a la URL de aprobación de PayPal
            // return redirect()->away($order['links'][1]['href']);
            if (isset($order['id']) && $order['id'] != null) {
                    foreach ($order['links'] as $link) {
                        if ($link['rel'] == 'approve') {
                            // session()->put('product_name', $request->product_name);
                            // session()->put('quantity', $request->quantity);
                            return redirect()->away($link['href']);
                        }
                    }
                } else {
                    return redirect()->route('user.cancel');
                }
        } catch (\Exception $e) {
            dd($e->getMessage()); // Mostrar el error en caso de fallo
            // Manejar el error al crear la orden
            return redirect()->back()->with('error', 'Error al crear la orden de PayPal: ' . $e->getMessage());
        }
    }

    public function success(Request $request){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if(isset($response['status']) && $response['status']=='COMPLETED'){
            Pago::create([
            'montoPagado'=>$response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
            'metodoPago'=>'paypal',
            'estado'=>$response['status'],
            'transaccion_id'=>$response['id'],
            'fechaPago'=>Carbon::now()->toDateTimeString(),
            'id_pedido' => session('pedido_id'),
            'moneda'=>$response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code']
            ]);
            $pedido=Pedido::where("id_pedido",session('pedido_id'))->first();
            $pedido->estado='completado';
            $pedido->save();
            // $carrito = Carrito::where('id_carrito',session('id_carrito'))->first();
            // $carrito->estado="completado";
            // $carrito->save();
            // session()->forget('id_carrito');
            session()->forget('pedido_id');
        }
        return redirect()->route("user.pedidos-detalles",$pedido->id_pedido);
        
        //dd($response);
    }

    public function failed(Request $request){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        $pedido=Pedido::with(['detalles.producto'])->findOrFail(session('pedido_id'));
        session()->forget('pedido_id');
        return redirect()->route('user.pedidos-detalles', $pedido->id_pedido);
        
        //dd($response);
    }

    public function generarPagoNuevamente($id_pedido)
    {
        $pedido = Pedido::with(['detalles.producto'])->findOrFail($id_pedido);
        
        // Verificar que el pedido esté pendiente
        if ($pedido->estado != 'pendiente') {
            return redirect()->route('detalles-pedido', $pedido->id_pedido)
                ->with('error', 'Solo puedes pagar pedidos con estado pendiente');
        }

        // Mapear los detalles a productos con estructura similar a carrito
        $productos = $pedido->detalles->map(function ($detalle) {
            return (object) [
                'id_producto' => $detalle->producto->id_producto,
                'nombre_producto' => $detalle->producto->nombre_producto,
                'descripcion' => $detalle->producto->descripcion ?? '',
                'pivot' => (object) [
                    'cantidad' => $detalle->cantidad,
                    'precioUnitario' => $detalle->precioUnitario,
                ],
            ];
        });

        // Configurar el proveedor de PayPal
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Preparar unidades de compra
        $purchase_units = [];
        $total_value = 0;

        foreach ($productos as $producto) {
            $purchase_units[] = [
                'name' => $producto->nombre_producto,
                'description' => $producto->descripcion,
                'quantity' => $producto->pivot->cantidad,
                'unit_amount' => [
                    'currency_code' => 'MXN', // Asegúrate que coincida con tu moneda
                    'value' => number_format($producto->pivot->precioUnitario, 2, '.', '')
                ],
            ];
            $total_value += $producto->pivot->precioUnitario * $producto->pivot->cantidad;
        }

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'MXN',
                        'value' => number_format($total_value, 2, '.', ''),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'MXN',
                                'value' => number_format($total_value, 2, '.', '')
                            ],
                            'items' => $purchase_units,
                        ],
                    ],
                    'description' => 'Pedido #' . $pedido->id_pedido,
                ],
            ],
            'application_context' => [
                'return_url' => route('user.success'),
                'cancel_url' => route('user.cancel')
            ],
        ];

        try {
            $order = $provider->createOrder($data);
            
            if (isset($order['id']) && $order['id'] != null) {
                foreach ($order['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        // Guardar el ID del pedido en sesión para el callback
                        session()->put('pedido_id', $pedido->id_pedido);
                        return redirect()->away($link['href']);
                    }
                }
            }
            
            return redirect()->route('detalles-pedido', $pedido->id_pedido)
                ->with('error', 'No se pudo obtener el enlace de pago de PayPal');

        } catch (\Exception $e) {
            return redirect()->route('detalles-pedido', $pedido->id_pedido)
                ->with('error', 'Error al conectar con PayPal: ' . $e->getMessage());
        }
    }

    // Cancelar un pedido pendiente
    public function cancelarPedido($id_pedido)
    {
        $pedido = Pedido::where('estado', 'pendiente')
                      ->findOrFail($id_pedido);
        
        // Actualizar estado del pedido
        $pedido->estado = 'Cancelado';
        $pedido->save();
        
        return redirect()->back()
                         ->with('success', 'El pedido ha sido cancelado exitosamente.');
    }
}
