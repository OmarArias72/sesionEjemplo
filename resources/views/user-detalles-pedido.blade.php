<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalle del Pedido - TechZone</title>
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
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="header bg-primary shadow-lg">
        <div class="container mx-auto px-4">
            <div class="header-content flex flex-wrap justify-between items-center py-4">
                <a href="{{ route('home') }}" class="logo text-white text-2xl font-bold hover:text-blue-200 transition">
                    TechZone
                </a>
                
                <!-- Barra de búsqueda integrada -->
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
                                <a href="{{ route('user.dashboard-usuario') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 active">
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

                <!-- Detalles del Pedido (Derecha) -->
                <div class="order-details-container flex-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Cabecera -->
                        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-receipt text-primary"></i>
                                Detalles del Pedido
                            </h1>
                            <p class="text-gray-500 text-sm mt-1">Información completa de tu compra</p>
                        </div>
                        
                        <!-- Resumen del Pedido -->
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-primary"></i>
                                Resumen del Pedido
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-hashtag text-primary mt-1 w-5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Número de Pedido</p>
                                        <p class="font-semibold text-gray-800">{{ $pedido['numero_pedido'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-calendar-alt text-primary mt-1 w-5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Fecha de Pedido</p>
                                        <p class="font-semibold text-gray-800">
                                            @if($pedido['fecha_pedido'] != 'No disponible')
                                                {{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d/m/Y H:i') }}
                                            @else
                                                {{ $pedido['fecha_pedido'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-truck text-primary mt-1 w-5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Estado del Envío</p>
                                        @php
                                            $envioClasses = [
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'enviado' => 'bg-blue-100 text-blue-800',
                                                'entregado' => 'bg-green-100 text-green-800',
                                                'cancelado' => 'bg-red-100 text-red-800',
                                            ];
                                            $envioClass = $envioClasses[strtolower($pedido['estado_envio'])] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $envioClass }}">
                                            <i class="fas 
                                                @if(strtolower($pedido['estado_envio']) == 'entregado') fa-check-circle
                                                @elseif(strtolower($pedido['estado_envio']) == 'enviado') fa-truck
                                                @elseif(strtolower($pedido['estado_envio']) == 'pendiente') fa-clock
                                                @else fa-times-circle
                                                @endif mr-1">
                                            </i>
                                            {{ $pedido['estado_envio'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-credit-card text-primary mt-1 w-5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Estado del Pago</p>
                                        @php
                                            $pagoClasses = [
                                                'completado' => 'bg-green-100 text-green-800',
                                                'completado' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                                'cancelado' => 'bg-red-100 text-red-800',
                                            ];
                                            $estadoPagoLower = strtolower($pedido['estado_pago']);
                                            $pagoClass = $pagoClasses[$estadoPagoLower] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pagoClass }}">
                                            <i class="fas 
                                                @if($estadoPagoLower == 'completado') fa-check-circle
                                                @elseif($estadoPagoLower == 'pending' || $estadoPagoLower == 'pendiente') fa-clock
                                                @else fa-times-circle
                                                @endif mr-1">
                                            </i>
                                            {{ $pedido['estado_pago'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-calendar-week text-primary mt-1 w-5"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Fecha Estimada de Entrega</p>
                                        <p class="font-semibold text-gray-800">
                                            @if($pedido['fecha_estimada_entrega'] != 'No disponible')
                                                {{ \Carbon\Carbon::parse($pedido['fecha_estimada_entrega'])->format('d/m/Y') }}
                                            @else
                                                {{ $pedido['fecha_estimada_entrega'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botón de Factura -->
                            @if($pedido['estado_pago'] === 'COMPLETED')
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <a href="{{ route('user.factura', $pedido['id_pedido']) }}" 
                                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition shadow-md hover:shadow-lg transform hover:scale-105 duration-300">
                                        <i class="fas fa-file-pdf text-lg"></i>
                                        Descargar Factura PDF
                                    </a>
                                </div>
                            @endif
                            
                            <!-- Acciones para pedido pendiente -->
                            @if($pedido['estado_pedido'] === 'pendiente')
                                <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3">
                                    <form method="POST" action="{{ route('user.cancelar-pedido', $pedido['id_pedido']) }}" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-lg transition shadow-md hover:shadow-lg" onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?')">
                                            <i class="fas fa-times-circle"></i>
                                            Cancelar Pedido
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('user.generar-pago-nuevamente', $pedido['id_pedido']) }}" class="inline-block">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-lg transition shadow-md hover:shadow-lg">
                                            <i class="fas fa-sync-alt"></i>
                                            Regenerar Pago
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Dirección de Envío -->
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                Dirección de Envío
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-road text-gray-400 mt-0.5 w-4"></i>
                                        <span class="text-gray-700">{{ $pedido['direccion_envio']['calle'] }} {{ $pedido['direccion_envio']['numero_exterior'] }}</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-location-dot text-gray-400 mt-0.5 w-4"></i>
                                        <span class="text-gray-700">Col. {{ $pedido['direccion_envio']['colonia'] }}</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-city text-gray-400 mt-0.5 w-4"></i>
                                        <span class="text-gray-700">{{ $pedido['direccion_envio']['ciudad'] }}</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-mail-bulk text-gray-400 mt-0.5 w-4"></i>
                                        <span class="text-gray-700">CP {{ $pedido['direccion_envio']['codigo_postal'] }}</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-map-pin text-gray-400 mt-0.5 w-4"></i>
                                        <span class="text-gray-700">{{ $pedido['direccion_envio']['estado'] }}</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-globe-americas text-gray-400 mt-0.5 w-4"></i>
                                        <span class="text-gray-700">{{ $pedido['direccion_envio']['pais'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabla de Productos -->
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-boxes text-primary"></i>
                                Productos
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Producto</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase w-24">Cantidad</th>
                                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase w-32">Precio Unitario</th>
                                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase w-32">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($pedido['productos'] as $producto)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-box text-gray-400"></i>
                                                    </div>
                                                    <span class="font-medium text-gray-800">{{ $producto['nombre'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-semibold text-gray-700">
                                                    {{ $producto['cantidad'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right text-gray-700">
                                                ${{ number_format($producto['precio_unitario'], 2) }}
                                            </td>
                                            <td class="px-4 py-3 text-right font-semibold text-gray-800">
                                                ${{ number_format($producto['total'], 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Total del Pedido -->
                        <div class="p-6 bg-gray-50">
                            <div class="flex justify-end">
                                <div class="w-full md:w-80">
                                    <div class="space-y-2">
                                        <div class="flex justify-between py-2">
                                            <span class="text-gray-600">Subtotal:</span>
                                            <span class="font-semibold text-gray-800">${{ number_format($pedido['subtotal'], 2) }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 border-t border-gray-200">
                                            <span class="text-xl font-bold text-gray-800">Total:</span>
                                            <span class="text-2xl font-bold text-primary">${{ number_format($pedido['total_pedido'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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