<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TiendaOnline - Gestión de Pedidos</title>
    <link rel="stylesheet" href="styles.css" />
    @vite('resources/css/app.css')
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body class="admin-body">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>N° Pedido</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>N° Productos</th>
                  <th>Total</th>
                  <th>Estado Pago</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pedidos as $pedido)
                <tr>
                  <td>#{{ $pedido->id_pedido }}</td>
                  <td>{{ $pedido->usuario->nombre }} {{ $pedido->usuario->apellido }}</td>
                  <td>
                    @if ($pedido->created_at)
                      {{ $pedido->created_at->format('Y-m-d') }}
                    @else
                        No disponible
                    @endif
                  </td>
                  <td>{{ $pedido->detalles ? $pedido->detalles->sum('cantidad') : 0 }}</td>
                  <td>${{ number_format($pedido->pago->montoPagado ?? 0, 2) }}</td>
                  <td>
                    @if($pedido->pago)
                      <span class="status-badge {{ $pedido->pago->estado == 'completado' ? 'paid' : 'pending' }}">
                        {{ ucfirst($pedido->pago->estado) }}
                      </span>
                    @else
                      <span class="status-badge pending">Sin pago</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!--Formulario para la asignacion de envios -->
            <h2>Asignación de Pedidos</h2>
            <form id="assignment-form" action="{{route('admin.store.envio')}}" method="POST">
              @csrf
              <label for="order-id-assign">Numero de Pedido:</label>
              <input
                type="text"
                id="order-id-assign"
                name="order-id-assign"
              />

              <label for="external-company">Empresa Externa:</label>
              <select id="external-company" name="external-company">
                  <option value="">Seleccione una empresa</option>
                  @foreach($empresas as $empresa)
                      <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombreEmpresa }}</option>
                  @endforeach
              </select>

              <button type="submit" class="btn btn-primary">
                Asignar envio
              </button>
            </form>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $pedidos->links() }}
            </div>
  </body>
</html>