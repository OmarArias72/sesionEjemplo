<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Administración de Pagos</title>
    <link rel="stylesheet" href="styles.css">
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
                    <li class="active">
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
                <h1>Gestión de Pagos</h1>
                
                <div class="admin-header-actions">
                    <div class="admin-search">
                        <input type="text" placeholder="Buscar pagos...">
                        <i class="fas fa-search"></i>
                    </div>
                    
                    <div class="admin-user">
                        <div class="admin-avatar">A</div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <!-- Payments Content -->
            <main class="admin-content">
                <div class="admin-toolbar">
                    <div class="admin-filters">
                        <select class="filter-select">
                            <option value="">Todos los métodos</option>
                            <option value="credit-card">Tarjeta de Crédito</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank-transfer">Transferencia Bancaria</option>
                        </select>
                        
                        <select class="filter-select">
                            <option value="">Todos los estados</option>
                            <option value="completed">Completado</option>
                            <option value="pending">Pendiente</option>
                            <option value="failed">Fallido</option>
                            <option value="refunded">Reembolsado</option>
                        </select>
                        
                        <div class="date-filter">
                            <label>Desde:</label>
                            <input type="date" class="date-input">
                        </div>
                        
                        <div class="date-filter">
                            <label>Hasta:</label>
                            <input type="date" class="date-input">
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
                                    <th>ID Transacción</th>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Método</th>
                                    <th>Importe</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>TRX-10289</td>
                                    <td class="order-id">#ORD-5289</td>
                                    <td>Juan Pérez</td>
                                    <td>19 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-cc-visa"></i> Visa ****4589
                                        </div>
                                    </td>
                                    <td>$129.99</td>
                                    <td><span class="payment-status paid">Completado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10288</td>
                                    <td class="order-id">#ORD-5288</td>
                                    <td>María García</td>
                                    <td>18 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-paypal"></i> PayPal
                                        </div>
                                    </td>
                                    <td>$89.99</td>
                                    <td><span class="payment-status paid">Completado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10287</td>
                                    <td class="order-id">#ORD-5287</td>
                                    <td>Carlos López</td>
                                    <td>18 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-cc-mastercard"></i> MasterCard ****7823
                                        </div>
                                    </td>
                                    <td>$199.99</td>
                                    <td><span class="payment-status paid">Completado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10286</td>
                                    <td class="order-id">#ORD-5286</td>
                                    <td>Ana Martínez</td>
                                    <td>17 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fas fa-university"></i> Transferencia Bancaria
                                        </div>
                                    </td>
                                    <td>$59.99</td>
                                    <td><span class="payment-status pending">Pendiente</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10285</td>
                                    <td class="order-id">#ORD-5285</td>
                                    <td>Roberto Sánchez</td>
                                    <td>17 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-cc-visa"></i> Visa ****1234
                                        </div>
                                    </td>
                                    <td>$149.99</td>
                                    <td><span class="payment-status paid">Completado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10284</td>
                                    <td class="order-id">#ORD-5284</td>
                                    <td>Laura Rodríguez</td>
                                    <td>16 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-cc-mastercard"></i> MasterCard ****5678
                                        </div>
                                    </td>
                                    <td>$299.99</td>
                                    <td><span class="payment-status paid">Completado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10283</td>
                                    <td class="order-id">#ORD-5283</td>
                                    <td>Pedro Gómez</td>
                                    <td>16 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-paypal"></i> PayPal
                                        </div>
                                    </td>
                                    <td>$79.99</td>
                                    <td><span class="payment-status refunded">Reembolsado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRX-10282</td>
                                    <td class="order-id">#ORD-5282</td>
                                    <td>Carmen Díaz</td>
                                    <td>15 Mar 2025</td>
                                    <td>
                                        <div class="payment-method">
                                            <i class="fab fa-cc-visa"></i> Visa ****9012
                                        </div>
                                    </td>
                                    <td>$119.99</td>
                                    <td><span class="payment-status paid">Completado</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="admin-pagination">
                        <span class="pagination-info">Mostrando 1-8 de 32 pagos</span>
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