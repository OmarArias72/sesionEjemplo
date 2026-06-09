<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis Pedidos - TechZone</title>
    {{-- Tailwind CSS v3 CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Archivo CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    {{-- Personalización de Tailwind para mantener consistencia --}}
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
    
    <style>
        /* Estilos adicionales para la paginación y estados */
        .pagination-btn {
            @apply px-3 py-1 border border-gray-300 rounded-md text-sm transition;
        }
        .pagination-btn:hover:not(:disabled) {
            @apply bg-primary text-white border-primary;
        }
        .pagination-btn.active {
            @apply bg-primary text-white border-primary;
        }
        .pagination-btn:disabled {
            @apply opacity-50 cursor-not-allowed;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="header bg-primary shadow-lg">
        <div class="container mx-auto px-4">
            <div class="header-content flex flex-wrap justify-between items-center py-4">
                <a href="{{ route('home') }}" class="logo text-white text-2xl font-bold hover:text-blue-200 transition">
                    TechZone
                </a>
                
                <!-- Barra de búsqueda integrada con los colores del sitio -->
                <div class="search-bar flex-1 max-w-md mx-4">
                    <form action="{{ route('productos.search') }}" method="GET" class="relative flex items-center bg-white rounded-lg border-2 border-blue-700/30 overflow-hidden focus-within:border-white focus-within:ring-2 focus-within:ring-blue-300 transition-all shadow-sm">
                        <input type="text" 
                               name="search"
                               placeholder="Buscar productos..." 
                               class="w-full bg-transparent px-4 py-2 text-gray-800 placeholder-gray-400 border-none outline-none focus:ring-0 text-sm" />
                        <button type="submit" 
                                class="bg-blue-800 hover:bg-primary-dark text-white h-full px-5 flex items-center justify-center transition-colors border-l border-blue-700/20 cursor-pointer">
                            <i class="fas fa-search text-xs tracking-wide"></i>
                        </button>
                    </form>
                </div>
                
                <nav class="nav-menu">
                    <ul class="flex space-x-4">
                        @auth
                            <li>
                                <a href="{{ route('user.carrito.ver') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2">
                                    <i class="fas fa-shopping-cart"></i> 
                                    <span>Carrito (<span class="cart-count">{{ auth()->user()->carritoActivoProductosCount() ?? 0 }}</span>)</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.dashboard-usuario') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2">
                                    <i class="fas fa-user"></i> Mi Cuenta
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2">
                                    <i class="fas fa-shopping-cart"></i> Carrito (0)
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2">
                                    <i class="fas fa-user"></i> Iniciar Sesión
                                </a>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content py-8">
        <div class="container mx-auto px-4">
            {{-- Layout con flexbox para sidebar izquierdo y contenido derecho --}}
            <div class="profile-layout flex flex-col md:flex-row gap-6">
                
                <!-- Sidebar (Izquierda) -->
                <aside class="client-sidebar w-full md:w-64 lg:w-72 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-primary to-primary-dark">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-primary text-xl"></i>
                            </div>
                            <div>
                                <p class="text-white font-semibold">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                                <p class="text-blue-100 text-sm">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="py-2">
                        <a href="{{ route('user.dashboard-usuario') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary transition group">
                            <i class="fas fa-user w-5 text-gray-500 group-hover:text-primary"></i>
                            <span>Mi Perfil</span>
                        </a>
                        
                        <a href="{{ route('user.perfil') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary transition group">
                            <i class="fas fa-edit w-5 text-gray-500 group-hover:text-primary"></i>
                            <span>Editar perfil</span>
                        </a>
                        
                        <a href="{{ route('user.direccion') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary transition group">
                            <i class="fas fa-map-marker-alt w-5 text-gray-500 group-hover:text-primary"></i>
                            <span>Editar dirección</span>
                        </a>
                        
                        <a href="{{ route('user.pedidos') }}" 
                           class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-primary font-semibold border-l-4 border-primary">
                            <i class="fas fa-box w-5"></i>
                            <span>Mis pedidos</span>
                        </a>
                        
                        <div class="border-t border-gray-200 my-2"></div>
                        
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="block">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition group">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Contenedor de pedidos (Derecha) -->
                <div class="orders-container flex-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-box text-primary"></i>
                                    Mis Pedidos
                                </h1>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    Últimos 30 días
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Historial completo de tus compras</p>
                        </div>
                        
                        <div class="overflow-x-auto">
                            @if($pedidos->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pedido</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($pedidos as $pedido)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-receipt text-primary text-sm"></i>
                                                    <span class="font-semibold text-gray-800">{{ $pedido['numero_pedido'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d M Y') }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $estadoClasses = [
                                                        'Completado' => 'bg-green-100 text-green-800',
                                                        'Procesando' => 'bg-blue-100 text-blue-800',
                                                        'Enviado' => 'bg-purple-100 text-purple-800',
                                                        'Cancelado' => 'bg-red-100 text-red-800',
                                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    ];
                                                    $estadoClass = $estadoClasses[$pedido['estado']] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoClass }}">
                                                    <i class="fas 
                                                        @if($pedido['estado'] == 'Completado') fa-check-circle
                                                        @elseif($pedido['estado'] == 'Procesando') fa-spinner fa-pulse
                                                        @elseif($pedido['estado'] == 'Enviado') fa-truck
                                                        @elseif($pedido['estado'] == 'Cancelado') fa-times-circle
                                                        @else fa-clock
                                                        @endif mr-1 text-xs">
                                                    </i>
                                                    {{ $pedido['estado'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-dollar-sign text-gray-400 text-sm"></i>
                                                    <span class="font-semibold text-gray-800">${{ number_format($pedido['total'], 2) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $pedidoId = str_replace('#ORD-', '', $pedido['numero_pedido']);
                                                @endphp
                                                <a href="{{ route('user.pedidos-detalles', ['pedidoId' => $pedidoId]) }}"
                                                   class="inline-flex items-center gap-1 text-primary hover:text-primary-dark transition font-medium text-sm">
                                                    <i class="fas fa-eye"></i>
                                                    Ver Detalles
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-box-open text-gray-400 text-4xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No tienes pedidos aún</h3>
                                    <p class="text-gray-500 mb-6">Parece que no has realizado ninguna compra todavía.</p>
                                    <a href="{{ route('productos.search') }}" 
                                       class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-2 rounded-lg transition shadow-md hover:shadow-lg">
                                        <i class="fas fa-shopping-cart"></i>
                                        Comenzar a comprar
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Paginación -->
                        @if($pedidos->count() > 0)
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Mostrando {{ $pedidos->firstItem() }} - {{ $pedidos->lastItem() }} de {{ $pedidos->total() }} pedidos
                                    </span>
                                    <div class="flex gap-1">
                                        @if($pedidos->onFirstPage())
                                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-400 cursor-not-allowed" disabled>
                                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                                            </button>
                                        @else
                                            <a href="{{ $pedidos->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-primary hover:text-white hover:border-primary transition">
                                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                                            </a>
                                        @endif
                                        
                                        <div class="flex gap-1">
                                            @foreach(range(1, min(5, $pedidos->lastPage())) as $page)
                                                @if($page == $pedidos->currentPage())
                                                    <button class="px-3 py-1 bg-primary text-white border border-primary rounded-md text-sm font-semibold">{{ $page }}</button>
                                                @else
                                                    <a href="{{ $pedidos->url($page) }}" class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-primary hover:text-white hover:border-primary transition">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                            
                                            @if($pedidos->lastPage() > 5)
                                                <span class="px-2 py-1 text-gray-500">...</span>
                                                <a href="{{ $pedidos->url($pedidos->lastPage()) }}" class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-primary hover:text-white hover:border-primary transition">
                                                    {{ $pedidos->lastPage() }}
                                                </a>
                                            @endif
                                        </div>
                                        
                                        @if($pedidos->hasMorePages())
                                            <a href="{{ $pedidos->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-primary hover:text-white hover:border-primary transition">
                                                Siguiente <i class="fas fa-chevron-right ml-1"></i>
                                            </a>
                                        @else
                                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-400 cursor-not-allowed" disabled>
                                                Siguiente <i class="fas fa-chevron-right ml-1"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Tarjeta de información adicional -->
                    {{-- <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-primary bg-opacity-10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info-circle text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">¿Necesitas ayuda con tu pedido?</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    Si tienes alguna pregunta sobre el estado de tu pedido o necesitas asistencia, 
                                    por favor contacta a nuestro servicio al cliente.
                                </p>
                                <button class="mt-2 text-primary hover:text-primary-dark text-sm font-medium inline-flex items-center gap-1">
                                    Contactar soporte
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer bg-gray-900 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="footer-content grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="footer-column">
                    <h3 class="text-xl font-bold mb-3">TechZone</h3>
                    <p class="text-gray-400">Tu tienda de confianza para compras en línea.</p>
                </div>
                <div class="footer-column">
                    <h4 class="font-semibold mb-3">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Inicio</a></li>
                        <li><a href="{{ route('productos.search') }}" class="text-gray-400 hover:text-white transition">Productos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="font-semibold mb-3">Categorías</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('productos.search', ['categoria' => 'electronica']) }}" class="text-gray-400 hover:text-white transition">Electrónica</a></li>
                        <li><a href="{{ route('productos.search', ['categoria' => 'ropa']) }}" class="text-gray-400 hover:text-white transition">Ropa</a></li>
                        <li><a href="{{ route('productos.search', ['categoria' => 'hogar']) }}" class="text-gray-400 hover:text-white transition">Hogar</a></li>
                        <li><a href="{{ route('productos.search', ['categoria' => 'deportes']) }}" class="text-gray-400 hover:text-white transition">Deportes</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="font-semibold mb-3">Contacto</h4>
                    <address class="not-italic text-gray-400 space-y-2">
                        <p><i class="fas fa-map-marker-alt mr-2"></i> Calle Principal 123</p>
                        <p><i class="fas fa-city mr-2"></i> Ciudad, País</p>
                        <p><i class="fas fa-envelope mr-2"></i> info@techzone.com</p>
                        <p><i class="fas fa-phone mr-2"></i> +123 456 7890</p>
                    </address>
                </div>
            </div>
            <div class="footer-bottom text-center pt-6 mt-6 border-t border-gray-800">
                <p class="text-gray-500">&copy; {{ date('Y') }} TechZone. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>