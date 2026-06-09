<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Administración de Productos</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Configuración de paleta extendida para consistencia --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a56db',
                        'primary-dark': '#1e429f',
                        'primary-light': '#e1effe',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-primary text-white flex flex-col fixed inset-y-0 left-0 z-20 shadow-xl">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold tracking-tight">TechZone</h1>
            </div>
            
            <nav class="flex-1 py-6">
                <ul class="space-y-1">
                    <li>
                        <a href="{{route('admin.dashboard-admin')}}" class="flex items-center gap-3 px-6 py-3 text-white/80 hover:bg-white/10 hover:text-white transition font-medium">
                            <i class="fas fa-chart-bar w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="bg-white/15 border-l-4 border-white font-semibold">
                        <a href="{{route('admin.productos')}}" class="flex items-center gap-3 px-6 py-3 text-white transition">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.pedidos')}}" class="flex items-center gap-3 px-6 py-3 text-white/80 hover:bg-white/10 hover:text-white transition font-medium">
                            <i class="fas fa-box w-5 text-center"></i>
                            <span>Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.envios')}}" class="flex items-center gap-3 px-6 py-3 text-white/80 hover:bg-white/10 hover:text-white transition font-medium">
                            <i class="fas fa-truck w-5 text-gray-200"></i>
                            <span>Envíos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.pagos')}}" class="flex items-center gap-3 px-6 py-3 text-white/80 hover:bg-white/10 hover:text-white transition font-medium">
                            <i class="fas fa-credit-card w-5 text-center"></i>
                            <span>Pagos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.configuracion')}}" class="flex items-center gap-3 px-6 py-3 text-white/80 hover:bg-white/10 hover:text-white transition font-medium">
                            <i class="fas fa-cog w-5 text-center"></i>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-red-600 hover:text-white transition font-medium cursor-pointer" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </form>
            </div>
        </aside>

        <div class="flex-1 ml-64 flex flex-col min-h-screen">
            
            <header class="bg-white h-16 px-6 flex items-center justify-between shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <h1 class="text-xl font-bold text-gray-800">Gestión de Productos</h1>
                
                <div class="flex items-center gap-6">
                    <div class="relative flex items-center bg-gray-100 rounded-lg border border-gray-300/60 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all w-64">
                        <input type="text" placeholder="Buscar productos..." class="w-full bg-transparent pl-9 pr-4 py-1.5 text-sm text-gray-800 outline-none placeholder-gray-400" />
                        <i class="fas fa-search absolute left-3 text-gray-400 text-xs"></i>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            A
                        </div>
                        <span class="text-sm font-semibold text-gray-700 hidden sm:inline">Admin</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 space-y-6">
                
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <button class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition cursor-pointer" 
                                data-url="{{ route('admin.productos.crear') }}">
                            <i class="fas fa-plus"></i> Añadir Producto
                        </button>

                        <button class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg shadow-sm border border-gray-300/70 transition cursor-pointer" 
                                data-url="{{ route('admin.editar-producto') }}">
                            <i class="fas fa-edit"></i> Editar Producto
                        </button>

                        <button class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg shadow-sm border border-gray-300/70 transition cursor-pointer" 
                                data-url="{{ route('admin.categorias') }}">
                            <i class="fas fa-tags"></i> Añadir Categoría
                        </button>
                    </div>
                    
                    <div class="w-full lg:w-auto">
                        <form id="filter-form" onsubmit="filterProducts(event)" class="flex flex-wrap items-center gap-3">
                            <select name="categoria" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition w-full sm:w-auto">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}" {{ request('categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <select name="stock" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition w-full sm:w-auto">
                                <option value="">Estado de stock</option>
                                <option value="in-stock" {{ request('stock') == 'in-stock' ? 'selected' : '' }}>En stock (&gt;15)</option>
                                <option value="low-stock" {{ request('stock') == 'low-stock' ? 'selected' : '' }}>Stock bajo (6-15)</option>
                                <option value="critical-stock" {{ request('stock') == 'critical-stock' ? 'selected' : '' }}>Stock crítico (1-5)</option>
                                <option value="out-of-stock" {{ request('stock') == 'out-of-stock' ? 'selected' : '' }}>Agotado (0)</option>
                            </select>
                            
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <button type="submit" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition cursor-pointer">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                                
                                <button type="button" onclick="resetFilters()" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg transition cursor-pointer">
                                    <i class="fas fa-times"></i> Limpiar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full">
                    <iframe id="admin-iframe" src="{{ route('admin.productos.tabla') }}" class="w-full block border-none min-h-[650px] bg-white">
                        
                    </iframe>
                </div>
            </main>
        </div>
    </div>

    <script>
        function filterProducts(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            
            const filteredUrl = "{{ route('admin.productos.tabla.filtrados') }}" + '?' + params;
            document.getElementById('admin-iframe').src = filteredUrl;
        }

        function resetFilters() {
            document.getElementById('filter-form').reset();
            document.getElementById('admin-iframe').src = "{{ route('admin.productos.tabla') }}";
        }

        function changePage(page) {
            const iframe = window.parent.document.getElementById('admin-iframe');
            const currentUrl = new URL(iframe.src);
            const isFiltered = currentUrl.pathname.includes('filtrados');
            
            currentUrl.searchParams.set('page', page);
            
            if (isFiltered) {
                const basePath = "{{ route('admin.productos.tabla.filtrados') }}".split('?')[0];
                const newUrl = basePath + '?' + currentUrl.searchParams.toString();
                iframe.src = newUrl;
            } else {
                iframe.src = currentUrl.toString();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('admin-iframe').src = "{{ route('admin.productos.tabla') }}";
            
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