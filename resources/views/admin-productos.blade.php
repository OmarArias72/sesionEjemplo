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
                    <button class="btn btn-primary" data-url="{{ route('admin.productos.crear') }}">
                        <i class="fas fa-plus"></i> Añadir Producto
                    </button>

                    <button class="btn btn-primary" data-url="{{ route('admin.categorias') }}">
                        <i class="fas fa-plus"></i> Añadir categoria
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
                    <iframe id="admin-iframe"></iframe>
                </div>
            </main>
        </div>
    </div>
    <script>
        // Función para cargar cualquier URL en el iframe
    function cargarEnIframe(url) {
        const iframe = document.getElementById('admin-iframe');
        iframe.src = url;
    }

    // Delegar el clic en botones con data-url
    document.addEventListener('click', function (e) {
        const boton = e.target.closest('button[data-url]');
        if (boton) {
            e.preventDefault();
            const url = boton.getAttribute('data-url');
            cargarEnIframe(url);
        }
    });
    </script>
</body>
</html>