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

                    <button class="btn btn-primary" data-url="{{ route('admin.editar-producto') }}">
                        <i class="fas fa-plus"></i> Editar Producto
                    </button>

                    <button class="btn btn-primary" data-url="{{ route('admin.categorias') }}">
                        <i class="fas fa-plus"></i> Añadir categoria
                    </button>
                    
                    <div class="admin-filters">
                        <form id="filter-form" onsubmit="filterProducts(event)">
                            <select name="categoria" class="filter-select">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}" {{ request('categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <select name="stock" class="filter-select">
                                <option value="">Estado de stock</option>
                                <option value="in-stock" {{ request('stock') == 'in-stock' ? 'selected' : '' }}>En stock (>15)</option>
                                <option value="low-stock" {{ request('stock') == 'low-stock' ? 'selected' : '' }}>Stock bajo (6-15)</option>
                                <option value="critical-stock" {{ request('stock') == 'critical-stock' ? 'selected' : '' }}>Stock crítico (1-5)</option>
                                <option value="out-of-stock" {{ request('stock') == 'out-of-stock' ? 'selected' : '' }}>Agotado (0)</option>
                            </select>
                            
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            
                            <button type="button" onclick="resetFilters()" class="btn btn-tertiary ml-2">
                                <i class="fas fa-times"></i> Limpiar filtros
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="admin-card">
                    <iframe id="admin-iframe" src="{{ route('admin.productos.tabla') }}">
                        
                    </iframe>
                </div>
            </main>
        </div>
    </div>
    <script>
       // Función para filtrar productos
        function filterProducts(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            
            // Construir la URL con la ruta específica para filtrados
            const filteredUrl = "{{ route('admin.productos.tabla.filtrados') }}" + '?' + params;
            
            // Cargar la URL filtrada en el iframe
            document.getElementById('admin-iframe').src = filteredUrl;
        }

        // Función para resetear los filtros
        function resetFilters() {
            // Resetear el formulario
            document.getElementById('filter-form').reset();
            
            // Cargar la URL sin filtros (ruta normal de tabla)
            document.getElementById('admin-iframe').src = "{{ route('admin.productos.tabla') }}";
        }

        // Función para cambiar de página (compatible con ambas rutas)
        function changePage(page) {
            const iframe = window.parent.document.getElementById('admin-iframe');
            const currentUrl = new URL(iframe.src);
            
            // Determinar si estamos en la ruta filtrada o normal
            const isFiltered = currentUrl.pathname.includes('filtrados');
            
            // Actualizar el parámetro de página
            currentUrl.searchParams.set('page', page);
            
            // Si estamos viendo resultados filtrados, asegurarnos de mantener la ruta correcta
            if (isFiltered) {
                const basePath = "{{ route('admin.productos.tabla.filtrados') }}".split('?')[0];
                const newUrl = basePath + '?' + currentUrl.searchParams.toString();
                iframe.src = newUrl;
            } else {
                iframe.src = currentUrl.toString();
            }
        }

        // Cargar el iframe al iniciar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar el iframe con la URL base
            document.getElementById('admin-iframe').src = "{{ route('admin.productos.tabla') }}";
            
            // Delegar eventos de clic para botones con data-url
            document.addEventListener('click', function(e) {
                const button = e.target.closest('button[data-url]');
                if (button) {
                    e.preventDefault();
                    document.getElementById('admin-iframe').src = button.getAttribute('data-url');
                }
            });
        });
    </script>
</body>
</html>