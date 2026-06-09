<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Panel de Administración</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-logo">TechZone</h1>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li class="active">
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
                <h1>Panel de Administración</h1>
                
                <div class="admin-header-actions">
                    <div class="admin-search">
                        <input type="text" placeholder="Buscar...">
                        <i class="fas fa-search"></i>
                    </div>
                    
                    <div class="admin-user">
                        <div class="admin-avatar">A</div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="admin-content">
                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                         <h3>Pedidos Totales</h3>
                        <div class="stat-value">
                            <p>{{ $totalPedidos ?? 0 }}</p>
                        </div>
                    </div>
                    
                </div>
                
                <div class="dashboard-grid">
                    <!-- Recent Orders -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h2>Pedidos Recientes</h2>
                        </div>
                        <div class="card-content">
                            <table class="admin-table">
                                 <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @forelse($pedidosRecientes as $pedido) <!-- Usar la variable pasada desde el controlador -->
                                        <tr>
                                            <td class="order-id">#ORD-{{ $pedido->id_pedido }}</td>
                                            <td>{{ $pedido->cliente }}</td>
                                            <td>{{ $pedido->formatted_date }}</td>
                                            <td>
                                                <span class="status-badge {{ $pedido->estado }}">
                                                    {{ ucfirst($pedido->estado) }}
                                                </span>
                                            </td>
                                            <td>{{ $pedido->formatted_total }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay pedidos recientes</td>
                                        </tr>
                                        @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('admin.pedidos')}}" class="view-all">Ver todos los pedidos →</a>
                        </div>
                    </div>
                    
                    <!-- Products -->
                    <div class="dashboard-card">
                        <div class="card-header">
                             <h2>Productos con bajo stock</h2>
                            <a href="{{ route('admin.productos') }}" class="btn btn-small">
                                <i class="fas fa-plus"></i> Gestionar Productos
                            </a>
                        </div>
                        <div class="card-content">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Precio</th>
                                        <th>Categoría</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productosBajoStock as $producto) <!-- Usar la variable pasada desde el controlador -->
                                        <tr>
                                            <td>{{ $producto->nombre_producto }}</td>
                                            <td>
                                                <span class="stock-badge {{ $producto->stock_status }}">
                                                    {{ $producto->stock }}
                                                </span>
                                            </td>
                                            <td>{{ $producto->formatted_price }}</td>
                                            <td>{{ $producto->categoria ?? 'Sin categoría' }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.editar-producto') }}" class="btn-icon edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    {{-- <form action="{{ route('admin.productos.eliminar', $producto->id_producto) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon delete" onclick="return confirm('¿Estás seguro?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay productos con bajo stock</td>
                                        </tr>
                                        @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('admin.productos')}}" class="view-all">Ver todos los productos →</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
    
</body>
</html>