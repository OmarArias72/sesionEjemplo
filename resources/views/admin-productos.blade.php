<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Administración de Productos</title>
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
                    <li>
                        <a href="{{route('admin.dashboard-admin')}}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="active">
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
                <h1>Gestión de Productos</h1>
                
                <div class="admin-header-actions">
                    <div class="admin-search">
                        <input type="text" placeholder="Buscar productos...">
                        <i class="fas fa-search"></i>
                    </div>
                    
                    <div class="admin-user">
                        <div class="admin-avatar">A</div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <!-- Products Content -->
            <main class="admin-content">
                <div class="admin-toolbar">
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> Añadir Producto
                    </button>
                    
                    <div class="admin-filters">
                        <select class="filter-select">
                            <option value="">Todas las categorías</option>
                            <option value="electronica">Electrónica</option>
                            <option value="ropa">Ropa</option>
                            <option value="hogar">Hogar</option>
                            <option value="deportes">Deportes</option>
                        </select>
                        
                        <select class="filter-select">
                            <option value="">Estado de stock</option>
                            <option value="in-stock">En stock</option>
                            <option value="low-stock">Stock bajo</option>
                            <option value="out-of-stock">Agotado</option>
                        </select>
                        
                        <button class="btn btn-secondary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </div>
                
                <div class="admin-card">
                    <div class="card-content">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th>SKU</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1598327105666-5b89351aff97?q=80&w=2027" alt="Smartphone XYZ Pro Max  alt="Smartphone XYZ Pro Max">
                                        </div>
                                    </td>
                                    <td>Smartphone XYZ Pro Max</td>
                                    <td>PROD-001</td>
                                    <td>Electrónica</td>
                                    <td>$899.99</td>
                                    <td><span class="stock-badge high">15</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071" alt="Laptop Pro">
                                        </div>
                                    </td>
                                    <td>Laptop Pro</td>
                                    <td>PROD-002</td>
                                    <td>Electrónica</td>
                                    <td>$1299.99</td>
                                    <td><span class="stock-badge medium">8</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070" alt="Auriculares Inalámbricos">
                                        </div>
                                    </td>
                                    <td>Auriculares Inalámbricos</td>
                                    <td>PROD-003</td>
                                    <td>Electrónica</td>
                                    <td>$89.99</td>
                                    <td><span class="stock-badge high">23</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1999" alt="Smartwatch">
                                        </div>
                                    </td>
                                    <td>Smartwatch</td>
                                    <td>PROD-004</td>
                                    <td>Electrónica</td>
                                    <td>$199.99</td>
                                    <td><span class="stock-badge high">12</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1780" alt="Camiseta Premium">
                                        </div>
                                    </td>
                                    <td>Camiseta Premium</td>
                                    <td>PROD-005</td>
                                    <td>Ropa</td>
                                    <td>$29.99</td>
                                    <td><span class="stock-badge high">45</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070" alt="Zapatillas Deportivas">
                                        </div>
                                    </td>
                                    <td>Zapatillas Deportivas</td>
                                    <td>PROD-006</td>
                                    <td>Ropa</td>
                                    <td>$79.99</td>
                                    <td><span class="stock-badge medium">9</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1507473885765-e6ed057f782c?q=80&w=1974" alt="Lámpara de Mesa">
                                        </div>
                                    </td>
                                    <td>Lámpara de Mesa</td>
                                    <td>PROD-007</td>
                                    <td>Hogar</td>
                                    <td>$49.99</td>
                                    <td><span class="stock-badge low">3</span></td>
                                    <td><span class="status-badge pending">Stock Bajo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon edit"><i class="fas fa-edit"></i></button>
                                            <button class="btn-icon delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item">
                                    </td>
                                    <td>
                                        <div class="product-thumbnail">
                                            <img src="https://images.unsplash.com/photo-1590794056226-79ef3a8147e1?q=80&w=1974" alt="Set de Cocina">
                                        </div>
                                    </td>
                                    <td>Set de Cocina</td>
                                    <td>PROD-008</td>
                                    <td>Hogar</td>
                                    <td>$119.99</td>
                                    <td><span class="stock-badge high">18</span></td>
                                    <td><span class="status-badge completed">Activo</span></td>
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
                    
                    <div class="admin-pagination">
                        <span class="pagination-info">Mostrando 1-8 de 24 productos</span>
                        <div class="pagination">
                            <button class="pagination-btn prev" disabled>Anterior</button>
                            <button class="pagination-btn active">1</button>
                            <button class="pagination-btn">2</button>
                            <button class="pagination-btn">3</button>
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