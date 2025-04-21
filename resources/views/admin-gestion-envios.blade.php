<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TiendaOnline - Gestión de Envíos</title>
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
                <li>
                    <a href="{{route('admin.pedidos')}}">
                        <i class="fas fa-box"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li class="active">
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
          <h1>Gestión de Envíos</h1>

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

        <!-- Gestión de Envíos Content -->
        <main class="admin-content">
          <div class="admin-envios">
            <h2>Listado de Pedidos</h2>

            <!-- Filtro por estado -->
            <div class="filter-section">
              <label for="filter-status">Filtrar por estado:</label>
              <select id="filter-status">
                <option value="todos">Todos</option>
                <option value="completado">Completado</option>
                <option value="pendiente">Pendiente</option>
                <option value="asignado">Asignado</option>
              </select>
            </div>

            <table class="admin-table">
              <thead>
                <tr>
                  <th>Pedido</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>Productos</th>
                  <th>Total</th>
                  <th>Pago</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#1001</td>
                  <td>Juan Pérez</td>
                  <td>2023-10-01</td>
                  <td>Producto 1 (x2), Producto 2 (x1)</td>
                  <td>$150.00</td>
                  <td><span class="status-badge paid">Pagado</span></td>
                </tr>
                <tr>
                  <td>#1002</td>
                  <td>María Gómez</td>
                  <td>2023-10-02</td>
                  <td>Producto 3 (x1)</td>
                  <td>$75.00</td>
                  <td><span class="status-badge pending">Pendiente</span></td>
                </tr>
                <tr>
                  <td>#1003</td>
                  <td>Carlos Ruiz</td>
                  <td>2023-10-03</td>
                  <td>Producto 4 (x3), Producto 5 (x2)</td>
                  <td>$200.00</td>
                  <td><span class="status-badge paid">Pagado</span></td>
                </tr>
              </tbody>
            </table>

            <h2>Asignación de Pedidos</h2>
            <form id="assignment-form">
              <label for="order-id-assign">ID Pedido:</label>
              <input
                type="text"
                id="order-id-assign"
                name="order-id-assign"
                readonly
              />

              <label for="external-company">Empresa Externa:</label>
              <select id="external-company" name="external-company">
                <option value="empresa1">Empresa 1</option>
                <option value="empresa2">Empresa 2</option>
                <option value="empresa3">Empresa 3</option>
              </select>

              <button type="submit" class="btn btn-primary">
                Asignar Pedido
              </button>
            </form>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
