<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
         // Obtener el usuario autenticado
         $user = Auth::user();

         // Obtener el ID del usuario autenticado
         $userId = $user->id_usuario;

        // Obtener los pedidos del usuario con relaciones y paginación
        $pedidos = Pedido::with(['detalles.producto', 'pago', 'envio'])
            ->where('id_usuario', $userId)
            ->select([
                'id_pedido',
                'fecha_pedido',
                'estado',
                'total'
            ])
            ->orderBy('fecha_pedido', 'desc')
            ->paginate(6);

        // Transformar los datos para la vista
        $pedidosTransformados = $pedidos->getCollection()->map(function ($pedido) {
            return [
                'numero_pedido' => '#ORD-' . $pedido->id_pedido,
                'fecha_pedido' => $pedido->fecha_pedido,
                'estado' => $pedido->estado,
                'total' => $pedido->total,
                'cantidad_productos' => $pedido->detalles->sum('cantidad'),
                'pago_estado' => $pedido->pago ? $pedido->pago->estado : 'No pagado',
                'envio_estado' => $pedido->envio ? $pedido->envio->estado : 'No enviado'
            ];
        });

        // Reemplazar la colección en el paginador
        $pedidos->setCollection($pedidosTransformados);

        return view("user-mis-pedidos", ['pedidos' => $pedidos]);
    }

    public function updatePerfil(Request $request){
        $user = Auth::user();
        
        // Validación de datos
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'regex:/^[0-9]+$/'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                Rule::unique('usuarios', 'email')->ignore($user->id_usuario, 'id_usuario')
            ]
        ]);

        try {
            // Actualizar los datos del usuario
            User::where('id_usuario', $user->id_usuario)->update($validatedData);

            // Redireccionar con mensaje de éxito
            return redirect()->back()->with([
                'status' => 'Perfil actualizado',
                'message' => 'Perfil actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la actualización
            return redirect()->back()->with([
                'status' => 'Actualizacion fallida',
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ])->withInput();
        }

    }
    public function updateDireccion(Request $request){
        $user = Auth::user();
        
        // Validación de datos
        $validatedData = $request->validate([
            'calle' => ['required', 'string', 'max:255'],
            'colonia' => ['required', 'string', 'max:255'],
            'numeroExterior' => ['string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:255'],
            'codigoPostal' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:255'],
            'pais' => ['required', 'string', 'max:255'],
            
            
        ]);

        try {
            // Obtener o crear la dirección del usuario
            $direccion = $user->direccion ?? new Direccion();
            
            // Actualizar los datos de dirección
            $direccion->fill($validatedData);
            $direccion->id_usuario = $user->id_usuario;
            $direccion->save();
    
            // Redireccionar con mensaje de éxito
            return redirect()->back()->with([
                'status' => 'exito',
                'message' => 'Dirección actualizada correctamente'
            ]);
    
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la actualización
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Error al actualizar la dirección: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function detallePedido($pedidoId)
    {
        //Log::info("NUMERO PEDIDO",["id"=>$pedidoId]);
        
        // Obtener el pedido con todas las relaciones necesarias
        $pedido = Pedido::with([
            'detalles.producto',
            'pago',
            'envio',
            'direccion',
            'usuario'
        ])->findOrFail($pedidoId);

        // Formatear los datos para la vista
        // Formatear los datos para la vista
        $datosPedido = [
            'id_pedido' => $pedido->id_pedido, // Añadimos el ID real para usar en los formularios
            'estado_pedido' => $pedido->estado, // Añadimos el estado real del pedido
            'numero_pedido' => '#ORD-' . $pedido->id_pedido,
            'fecha_pedido' => $pedido->created_at  ?? 'No disponible',
            'estado_envio' => $pedido->envio->estado ?? 'No disponible',
            'estado_pago' => $pedido->pago->estado ?? 'No pagado',
            'fecha_estimada_entrega' => $pedido->envio->fechaEstimadaEntrega ?? 'No disponible',
            'direccion_envio' => [
                'calle' => $pedido->direccion->calle ?? 'No especificada',
                'numero_exterior' => $pedido->direccion->numeroExterior ?? 'S/N',
                'colonia' => $pedido->direccion->colonia ?? 'No especificada',
                'ciudad' => $pedido->direccion->ciudad ?? 'No especificada',
                'codigo_postal' => $pedido->direccion->codigoPostal ?? 'No especificado',
                'estado' => $pedido->direccion->estado ?? 'No especificado',
                'pais' => $pedido->direccion->pais ?? 'No especificado'
            ],
            'productos' => $pedido->detalles->map(function ($detalle) {
                return [
                    'nombre' => $detalle->producto->nombre_producto ?? 'Producto no disponible',
                    'cantidad' => $detalle->cantidad ?? 0,
                    'precio_unitario' => $detalle->precioUnitario ?? 0,
                    'total' => ($detalle->cantidad ?? 0) * ($detalle->precioUnitario ?? 0)
                ];
            }),
            'total_pedido' => $pedido->total ?? 0,
            'subtotal' => $pedido->subtotal
        ];

        return view('user-detalles-pedido', ['pedido' => $datosPedido]);
    }
}
