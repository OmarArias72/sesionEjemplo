<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Panel de Administración</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <li class="active">
                        <a href="admin.html">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin-productos.html">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin-pedidos.html">
                            <i class="fas fa-box"></i>
                            <span>Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin-gestion-envios.html">
                            <i class="fas fa-truck"></i>
                            <span>Envíos</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin-pagos.html">
                            <i class="fas fa-credit-card"></i>
                            <span>Pagos</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin-configuracion.html">
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
                        <h3>Ventas Totales</h3>
                        <div class="stat-value">
                            <p>$12,345.67</p>
                            <span class="stat-change positive">+12.5%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Pedidos</h3>
                        <div class="stat-value">
                            <p>156</p>
                            <span class="stat-change positive">+8.2%</span>
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
                                    <tr>
                                        <td class="order-id">#ORD-5289</td>
                                        <td>Juan Pérez</td>
                                        <td>19 Mar 2025</td>
                                        <td><span class="status-badge completed">Completado</span></td>
                                        <td>$129.99</td>
                                    </tr>
                                    <tr>
                                        <td class="order-id">#ORD-5288</td>
                                        <td>María García</td>
                                        <td>18 Mar 2025</td>
                                        <td><span class="status-badge processing">Procesando</span></td>
                                        <td>$89.99</td>
                                    </tr>
                                    <tr>
                                        <td class="order-id">#ORD-5287</td>
                                        <td>Carlos López</td>
                                        <td>18 Mar 2025</td>
                                        <td><span class="status-badge shipped">Enviado</span></td>
                                        <td>$199.99</td>
                                    </tr>
                                    <tr>
                                        <td class="order-id">#ORD-5286</td>
                                        <td>Ana Martínez</td>
                                        <td>17 Mar 2025</td>
                                        <td><span class="status-badge pending">Pendiente</span></td>
                                        <td>$59.99</td>
                                    </tr>
                                    <tr>
                                        <td class="order-id">#ORD-5285</td>
                                        <td>Roberto Sánchez</td>
                                        <td>17 Mar 2025</td>
                                        <td><span class="status-badge completed">Completado</span></td>
                                        <td>$149.99</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="admin-pedidos.html" class="view-all">Ver todos los pedidos →</a>
                        </div>
                    </div>
                    
                    <!-- Products -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h2>Productos</h2>
                            <button class="btn btn-small">
                                <i class="fas fa-plus"></i> Añadir Producto
                            </button>
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
                                    <tr>
                                        <td>Smartphone XYZ Pro Max</td>
                                        <td><span class="stock-badge high">15</span></td>
                                        <td>$899.99</td>
                                        <td>Electrónica</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Laptop Pro</td>
                                        <td><span class="stock-badge medium">8</span></td>
                                        <td>$1299.99</td>
                                        <td>Electrónica</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Auriculares Inalámbricos</td>
                                        <td><span class="stock-badge high">23</span></td>
                                        <td>$89.99</td>
                                        <td>Electrónica</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Smartwatch</td>
                                        <td><span class="stock-badge high">12</span></td>
                                        <td>$199.99</td>
                                        <td>Electrónica</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Camiseta Premium</td>
                                        <td><span class="stock-badge high">45</span></td>
                                        <td>$29.99</td>
                                        <td>Ropa</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="admin-productos.html" class="view-all">Ver todos los productos →</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!--FORMULARIO PARA CERRAR SESION -->
        
    </div>
    
</body>
</html>