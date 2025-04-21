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
              <select class="filter-select">
                <option value="">Todos los estados</option>
                <option value="pending">Pendiente</option>
                <option value="processing">Procesando</option>
                <option value="shipped">Enviado</option>
                <option value="completed">Completado</option>
                <option value="cancelled">Cancelado</option>
              </select>

              <div class="date-filter">
                <label>Desde:</label>
                <input type="date" class="date-input" />
              </div>

              <div class="date-filter">
                <label>Hasta:</label>
                <input type="date" class="date-input" />
              </div>

              <button class="btn btn-secondary">
                <i class="fas fa-filter"></i> Filtrar
              </button>
            </div>

            <button class="btn btn-primary">
              <i class="fas fa-file-export"></i> Exportar
            </button>
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
                    <th>Estado del Envío</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="order-id">#ORD-5289</td>
                    <td>Juan Pérez</td>
                    <td>19 Mar 2025</td>
                    <td>2 productos</td>
                    <td>$129.99</td>
                    <td>
                      <span class="status-badge completed">Completado</span>
                    </td>
                    <td><span class="payment-status paid">Pagado</span></td>
                    <td>
                      <select class="shipping-status">
                        <option value="pendiente">Pendiente</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregado">Entregado</option>
                      </select>
                      <button class="btn btn-small btn-primary">
                        Actualizar
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td class="order-id">#ORD-5288</td>
                    <td>María García</td>
                    <td>18 Mar 2025</td>
                    <td>1 producto</td>
                    <td>$89.99</td>
                    <td>
                      <span class="status-badge processing">Procesando</span>
                    </td>
                    <td><span class="payment-status paid">Pagado</span></td>
                    <td>
                      <select class="shipping-status">
                        <option value="pendiente">Pendiente</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregado">Entregado</option>
                      </select>
                      <button class="btn btn-small btn-primary">
                        Actualizar
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td class="order-id">#ORD-5287</td>
                    <td>Carlos López</td>
                    <td>18 Mar 2025</td>
                    <td>3 productos</td>
                    <td>$199.99</td>
                    <td><span class="status-badge shipped">Enviado</span></td>
                    <td><span class="payment-status paid">Pagado</span></td>
                    <td>
                      <select class="shipping-status">
                        <option value="pendiente">Pendiente</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregado">Entregado</option>
                      </select>
                      <button class="btn btn-small btn-primary">
                        Actualizar
                      </button>
                    </td>
                  </tr>
                  <!-- Más filas de pedidos pueden ser añadidas aquí -->
                </tbody>
              </table>
            </div>

            <div class="admin-pagination">
              <span class="pagination-info">Mostrando 1-8 de 32 pedidos</span>
              <div class="pagination">
                <button class="pagination-btn prev" disabled>Anterior</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">4</button>
                <button class="pagination-btn next">Siguiente</button>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script src="js/cerrar_sesion.js"></script>
  </body>
</html>
