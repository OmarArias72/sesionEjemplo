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
    <div class="admin-layout">
      <!-- Sidebar -->
      <aside class="admin-sidebar">
        <div class="sidebar-header">
            <h1 class="sidebar-logo">TiendaOnline</h1>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="{{route('admin.dashboard-admin')}}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.productos')}}">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{route('admin.pedidos')}}">
                        <i class="fas fa-box"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.envios')}}">
                        <i class="fas fa-truck"></i>
                        <span>Envíos</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.pagos')}}">
                        <i class="fas fa-credit-card"></i>
                        <span>Pagos</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.configuracion')}}">
                        <i class="fas fa-cog"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </form>
        </div>
    </aside>

      <!-- Main Content -->
      <div class="admin-main">
        <!-- Header -->
        <header class="admin-header">
          <h1>Gestión de Pedidos</h1>

          <div class="admin-header-actions">
            <div class="admin-search">
              <input type="text" placeholder="Buscar..." />
              <i class="fas fa-search"></i>
            </div>

            <div class="admin-user">
              <div class="admin-avatar">A</div>
              <span>Admin</span>
            </div>
          </div>
        </header>

        <!-- Gestión de Pedidos Content -->
        <main class="admin-content">
          <div class="admin-pedidos">
            <h2>Listado de Pedidos</h2>

            <!-- Filtro por estado -->
            <div class="filter-section">
              <label for="filter-status">Filtrar por estado:</label>
              <select id="filter-status">
                <option value="todos">Todos</option>
                <option value="completado">Completado</option>
                <option value="pendiente">Pendiente</option>
                <option value="cancelado">Cancelado</option>
              </select>
            </div>

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

            <!-- Paginación -->
            <div class="mt-4">
                {{ $pedidos->links() }}
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>