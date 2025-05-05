<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;

class EnvioController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            "order-id-assign" => "required|string",
            "external-company" => "required|exists:empresas_envio,id_empresa"
        ]);

        DB::beginTransaction();
        
        try {
            // Limpiar y obtener ID del pedido
            $idOrden = str_replace("#", "", $validated['order-id-assign']);
            $pedido = Pedido::findOrFail($idOrden);

            // Verificar si el pedido ya tiene envío
            if ($pedido->tieneEnvio()) {
                throw new \Exception('Este pedido ya tiene un envío asignado.');
            }

            // Crear el envío
            $envio = Envio::create([
                "id_empresa" => $validated['external-company'],
                "estado" => Envio::ESTADO_PENDIENTE,
                "id_pedido" => $pedido->id_pedido,
            ]);

            // Actualizar estado del pedido si es necesario
            // $pedido->update(['estado' => 'en_proceso']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Envío asignado correctamente',
                'tracking_code' => $envio->codigoSeguimiento
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("Pedido no encontrado: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'El pedido especificado no existe'
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al asignar envío: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function obtenerEnvios(){

        $envios = Envio::with(['pedido', 'empresa'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(6); // 6 elementos por página

         // Convertir fechas a Carbon si es necesario
        $envios->transform(function ($envio) {
            $envio->fechaEnvio = $envio->fechaEnvio ? \Carbon\Carbon::parse($envio->fechaEnvio) : null;
            $envio->fechaEstimadaEntrega = $envio->fechaEstimadaEntrega ? \Carbon\Carbon::parse($envio->fechaEstimadaEntrega) : null;
            $envio->fechaEntrega = $envio->fechaEntrega ? \Carbon\Carbon::parse($envio->fechaEntrega) : null;
            return $envio;
        });
                      
        return view('admin-editar-envio', compact('envios'));
    
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'numero_envio' => 'exists:envios,id_envio',
            'estado' => 'in:Pendiente,Enviado,Entregado,Cancelado',
            'codigoSeguimiento' => 'sometimes|nullable|string|max:50',
            'fechaEnvio' => 'nullable|date',
            'fechaEstimadaEntrega' => 'nullable|date',
            'fechaEntrega' => 'nullable|date'
        ]);

        // Iniciar transacción
    DB::beginTransaction();

        try {
            // Buscar el envío
            $envio = Envio::findOrFail($validated['numero_envio']);

            // Actualizar el envío
            $envio->update([
                'estado' => $validated['estado'],
                'codigoSeguimiento' => $validated['codigoSeguimiento'] ?? $envio->codigoSeguimiento,
                'fechaEnvio' => $validated['fechaEnvio'],
                'fechaEstimadaEntrega' => $validated['fechaEstimadaEntrega'],
                'fechaEntrega' => $validated['fechaEntrega']
            ]);

            // Si el estado es "Entregado" y no hay fecha de entrega, establecerla automáticamente
            if ($validated['estado'] === 'Entregado' && empty($validated['fechaEntrega'])) {
                $envio->fechaEntrega = now();
                $envio->save();
            }

            // Confirmar la transacción
            DB::commit();

            return back()->with('success', 'Envío actualizado correctamente');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Envío no encontrado - Rollback
            DB::rollBack();
            Log::error("Envío no encontrado: " . $e->getMessage());
            return back()->with('error', 'El envío especificado no existe');

        } catch (\Exception $e) {
            // Cualquier otro error - Rollback
            DB::rollBack();
            Log::error("Error al actualizar envío: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al actualizar el envío');
        }
    }

    public function listaEnvios(){
        $envios = Envio::with(['pedido', 'empresa'])
        ->orderBy('created_at', 'desc')
        ->paginate(8); // 8 elementos por página como solicitado
        
        return view('admin-lista-envios', compact('envios'));
    }
}
