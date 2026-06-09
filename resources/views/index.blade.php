<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Inicio</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Inclusión CDN para asegurar soporte extendido de paleta de colores y utilidades --}}
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
<body class="bg-gray-50 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    <!-- ========================================
         HEADER
    ========================================= -->
    <header class="bg-primary shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <a href="{{route('home')}}" class="text-white text-2xl font-bold hover:text-blue-200 transition-colors">TechZone</a>
                
                <!-- Barra de búsqueda mejorada e integrada horizontalmente -->
                <div class="flex-1 max-w-md mx-4">
                    <form action="{{ route('productos.search') }}" method="GET" class="relative flex items-center bg-white rounded-lg border-2 border-blue-700/30 overflow-hidden focus-within:border-white focus-within:ring-2 focus-within:ring-blue-300 transition-all shadow-sm">
                        <input type="text" name="query" placeholder="Buscar productos..." class="w-full bg-transparent px-4 py-2 text-gray-800 placeholder-gray-400 border-none outline-none focus:ring-0 text-sm" />
                        <button type="submit" class="bg-blue-800 hover:bg-primary-dark text-white h-full px-5 flex items-center justify-center transition-colors border-l border-blue-700/20 cursor-pointer" style="align-self: stretch;">
                            <i class="fas fa-search text-xs tracking-wide"></i>
                        </button>
                    </form>
                </div>
                
                <nav class="nav-menu">
                    <ul class="flex space-x-6 items-center">
                        @auth
                            <li>
                                <a href="{{route('user.carrito.ver')}}" class="text-white hover:text-blue-200 transition flex items-center gap-2 font-medium text-sm">
                                    <i class="fas fa-shopping-cart"></i> Carrito ({{ auth()->user()->carritoActivoProductosCount() }})
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.dashboard-usuario') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 font-semibold text-sm border-b-2 border-white pb-0.5">
                                    <i class="fas fa-user"></i> Mi Cuenta
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 text-sm font-medium">
                                    <i class="fas fa-shopping-cart"></i> Carrito (0)
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 text-sm font-medium">
                                    <i class="fas fa-user"></i> Iniciar Sesión
                                </a>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- ========================================
         HERO SECTION
    ========================================= -->
    <section class="relative bg-gradient-to-r from-primary to-primary-dark text-white py-16 md:py-24 shadow-inner">
        <div class="container mx-auto px-4 text-center space-y-6">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">Bienvenido a nuestra Tienda Online</h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Descubre los mejores productos con los mejores precios y el rendimiento que tu setup necesita.</p>
            <div class="pt-2">
                <a href="{{ route('productos.search') }}" class="inline-flex items-center justify-center bg-white hover:bg-blue-50 text-primary font-bold px-8 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Ver Catálogo <i class="fas fa-arrow-right text-xs ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================
         FEATURED CATEGORIES
    ========================================= -->
    <section class="container mx-auto px-4 py-16">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-8 tracking-tight text-center md:text-left flex items-center justify-center md:justify-start gap-3">
            <span class="w-2 h-8 bg-primary rounded-full hidden md:block"></span> Categorías Destacadas
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categoriasDestacadas as $categoria)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-gray-300 transition-all">
                <div class="h-48 overflow-hidden bg-gray-50 flex items-center justify-center relative">
                    @if($categoria->producto_destacado_imagen)
                        <img src="{{ $categoria->imagen_producto_destacado }}" alt="{{ $categoria->nombre_categoria }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="https://via.placeholder.com/300x200?text={{ urlencode($categoria->nombre_categoria) }}" alt="{{ $categoria->nombre_categoria }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                
                <div class="p-6 flex flex-col flex-1 space-y-3">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $categoria->nombre_categoria }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed flex-1">{{ $categoria->descripcion }}</p>
                    
                    <form action="{{ route('productos.filtrados') }}" method="GET" class="pt-2 m-0">
                        <input type="hidden" name="categories[]" value="{{ $categoria->id_categoria }}">
                        <button type="submit" class="w-full inline-flex items-center justify-center bg-gray-100 hover:bg-primary hover:text-white text-gray-700 font-semibold text-sm px-4 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer">
                            Ver productos
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================
         FEATURED PRODUCTS
    ========================================= -->
    <section class="bg-gray-100/60 border-y border-gray-200/50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-8 tracking-tight text-center md:text-left flex items-center justify-center md:justify-start gap-3">
                <span class="w-2 h-8 bg-primary rounded-full hidden md:block"></span> Productos Más Vendidos
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($productosMasVendidos as $producto)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-gray-300 transition-all">
                    <!-- Contenedor Imagen -->
                    <div class="h-52 bg-white p-4 flex items-center justify-center relative border-b border-gray-100 shrink-0">
                        <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="{{ $producto->nombre_producto }}" class="max-h-full object-contain mix-blend-multiply group-hover:scale-102 transition-transform duration-300">
                        <span class="absolute top-3 left-3 bg-amber-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-md uppercase tracking-wider shadow-sm">Top Ventas</span>
                    </div>
                    
                    <!-- Información Interna -->
                    <div class="p-5 flex flex-col flex-1 space-y-3">
                        <h3 class="text-base font-bold text-gray-900 line-clamp-2 leading-tight flex-1">{{ $producto->nombre_producto }}</h3>
                        
                        <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                            <span class="text-xl font-extrabold text-gray-900 tracking-tight">${{ number_format($producto->precio, 2) }}</span>
                            <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-1 rounded">Vendidos: {{ $producto->total_vendido }}</span>
                        </div>
                        
                        <!-- Acciones -->
                        <div class="flex items-center justify-between gap-3 pt-2">
                            <a href="{{ route('productos.show', $producto->id_producto) }}" class="text-xs font-bold text-primary hover:text-primary-dark hover:underline whitespace-nowrap transition-colors">
                                Ver detalles
                            </a>
                            
                            <form action="{{ route('user.carrito.agregar') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                                
                                @auth
                                    <button type="submit" class="inline-flex items-center bg-primary hover:bg-primary-dark text-white text-xs font-bold px-3.5 py-2 rounded-lg shadow-sm transition-colors cursor-pointer">
                                        <i class="fas fa-plus mr-1"></i> Añadir
                                    </button>
                                @else
                                    <div class="relative group/tooltip inline-block">
                                        <button type="button" class="inline-flex items-center bg-gray-200 text-gray-400 text-xs font-bold px-3.5 py-2 rounded-lg cursor-not-allowed" disabled>
                                            <i class="fas fa-plus mr-1"></i> Añadir
                                        </button>
                                        <!-- Mini Tooltip contextual flotante -->
                                        <div class="absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block w-48 bg-gray-900 text-white text-[10px] font-medium p-2 rounded-md shadow-lg text-center leading-tight z-30">
                                            Debes iniciar sesión para comprar
                                        </div>
                                    </div>
                                @endauth
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================
         FOOTER
    ========================================= -->
    <footer class="bg-gray-900 text-white border-t border-gray-800 mt-auto">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="footer-column">
                    <h3 class="text-xl font-bold mb-4 tracking-tight">TechZone</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Tu tienda de confianza para compras en línea con los mejores precios y calidad garantizada en hardware.</p>
                </div>
                <div class="footer-column">
                    <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-sm p-0 m-0">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                        <li><a href="{{ route('productos.search') }}" class="text-gray-400 hover:text-white transition-colors">Productos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Sobre Nosotros</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Categorías</h4>
                    <ul class="space-y-2 text-sm p-0 m-0">
                        <li><a href="{{ route('productos.search', ['categoria' => 'electronica']) }}" class="text-gray-400 hover:text-white transition-colors">Electrónica</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Contacto</h4>
                    <address class="not-italic text-sm text-gray-400 space-y-2">
                        <p><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i> Calle Principal 123</p>
                        <p><i class="fas fa-city mr-2 text-gray-500"></i> Ciudad, País</p>
                        <p><i class="fas fa-envelope mr-2 text-gray-500"></i> info@TechZone.com</p>
                        <p><i class="fas fa-phone mr-2 text-gray-500"></i> +123 456 7890</p>
                    </address>
                </div>
            </div>
            <div class="text-center pt-8 mt-8 border-t border-gray-800 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} TechZone. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>