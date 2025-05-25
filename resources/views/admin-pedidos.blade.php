<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TiendaOnline - Administración de Pedidos</title>
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
        
        {{-- <div class="sidebar-footer">
            <a href="#" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar Sesión</span>
            </a>
        </div> --}}
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
              <input type="text" placeholder="Buscar pedidos..." />
              <i class="fas fa-search"></i>
            </div>

            <div class="admin-user">
              <div class="admin-avatar">A</div>
              <span>Admin</span>
            </div>
          </div>
        </header>

        <!-- Orders Content -->
        <main class="admin-content">
          <div class="admin-toolbar">
            <div class="admin-filters">
              <form method="GET" action="{{ route('admin.pedidos-filtrados') }}" class="flex items-center gap-4">
                  @csrf
                  <select name="estado" class="filter-select">
                      <option value="todos">Todos los estados</option>
                      <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                      <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                      <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                  </select>

                  <div class="date-filter">
                      <label>Desde:</label>
                      <input type="date" name="fecha_desde" class="date-input" value="{{ request('fecha_desde') }}" />
                  </div>

                  <div class="date-filter">
                      <label>Hasta:</label>
                      <input type="date" name="fecha_hasta" class="date-input" value="{{ request('fecha_hasta') }}" />
                  </div>

                  <button type="submit" class="btn btn-secondary">
                      <i class="fas fa-filter"></i> Filtrar
                  </button>

                  @if(request('estado') || request('fecha_desde') || request('fecha_hasta'))
                      <a href="{{ route('admin.pedidos') }}" class="btn btn-danger">
                          <i class="fas fa-times"></i> Limpiar
                      </a>
                  @endif
              </form>
          </div>

            {{-- <button class="btn btn-primary">
              <i class="fas fa-file-export"></i> Exportar
            </button> --}}
          </div>

          <div class="admin-card">
            <div class="card-content">
               <table class="admin-table">
              <thead>
                <tr>
                  <th>Pedido</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>Productos</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Pago</th>
                  {{-- <th>Acciones</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach($pedidos as $pedido)
                <tr>
                  <td class="order-id">#ORD-{{ $pedido->id_pedido }}</td>
                  <td>{{ $pedido->usuario->nombre }} {{ $pedido->usuario->apellido }}</td>
                  <td>{{ $pedido->created_at->format('d M Y') }}</td>
                  <td>{{ $pedido->detalles->count() }} productos</td>
                  <td>${{ number_format($pedido->total, 2) }}</td>
                  <td>
                    <span class="status-badge {{ $pedido->estado }}">{{ ucfirst($pedido->estado) }}</span>
                  </td>
                  <td>
                    <span class="payment-status {{ $pedido->pago->estado ?? 'pending' }}">
                      {{ ucfirst($pedido->pago->estado ?? 'Pendiente') }}
                    </span>
                  </td>
                  {{-- <td>
                    <a href="{{ route('admin.pedidos.detalle', $pedido->id_pedido) }}" class="btn btn-small btn-primary">
                      Ver Detalle
                    </a>
                  </td> --}}
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>

            <div class="admin-pagination">
               {{ $pedidos->links() }}
            </div>
          </div>
        </main>
      </div>
    </div>
    <script></script>
  </body>
</html>
