<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Carrito de Compras</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Inclusión complementaria del script para soporte extendido de paleta --}}
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

    <header class="bg-primary shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <a href="{{ route('home') }}" class="text-white text-2xl font-bold hover:text-blue-200 transition-colors">TechZone</a>
                
                <div class="flex-1 max-w-md mx-4">
                    <form action="#" method="GET" class="relative flex items-center bg-white rounded-lg border-2 border-blue-700/30 overflow-hidden focus-within:border-white focus-within:ring-2 focus-within:ring-blue-300 transition-all shadow-sm">
                        <input type="text" placeholder="Buscar productos..." class="w-full bg-transparent px-4 py-2 text-gray-800 placeholder-gray-400 border-none outline-none focus:ring-0 text-sm" />
                        <button type="submit" class="bg-blue-800 hover:bg-primary-dark text-white h-full px-5 flex items-center justify-center transition-colors border-l border-blue-700/20 cursor-pointer" style="align-self: stretch;">
                            <i class="fas fa-search text-xs tracking-wide"></i>
                        </button>
                    </form>
                </div>
                
                <nav class="nav-menu">
                    <ul class="flex space-x-6 items-center">
                        @auth
                            <li>
                                <a href="{{ route('user.carrito.ver') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 font-semibold text-sm border-b-2 border-white pb-0.5">
                                    <i class="fas fa-shopping-cart"></i> Carrito ({{ $cartItems->count() }})
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.dashboard-usuario') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 font-medium text-sm">
                                    <i class="fas fa-user"></i> Mi Cuenta
                                </a>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 text-sm font-medium"><i class="fas fa-shopping-cart"></i> Carrito (0)</a></li>
                            <li><a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 text-sm font-medium"><i class="fas fa-user"></i> Iniciar Sesión</a></li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 mt-6">
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <main class="flex-1 container mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">Tu Carrito</h1>
        
        @if($cartItems->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center max-w-xl mx-auto shadow-sm">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <i class="fas fa-shopping-basket text-2xl"></i>
                </div>
                <p class="text-lg text-gray-600 font-medium mb-6">Tu carrito actualmente está vacío</p>
                <a href="{{ route('productos.search') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-xl transition shadow-sm cursor-pointer">
                    Comenzar a comprar <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse text-left text-sm">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th scope="col" class="px-6 py-4">Producto</th>
                                        <th scope="col" class="px-6 py-4 text-center">Cantidad</th>
                                        <th scope="col" class="px-6 py-4">Precio</th>
                                        <th scope="col" class="px-6 py-4">Subtotal</th>
                                        <th scope="col" class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-16 h-16 border border-gray-200 rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center shrink-0">
                                                        <img src="{{ asset('imagenes/' . $item->producto->url_imagen) ?? 'https://via.placeholder.com/80x80?text=Producto' }}" alt="{{ $item->producto->nombre_producto }}" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="font-semibold text-gray-900 hover:text-primary transition-colors">
                                                        <a href="{{ route('productos.show', $item->producto->id_producto) }}">
                                                            {{ $item->producto->nombre_producto }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="inline-block">
                                                    <form action="{{ route('user.carrito.update', $item->id_carrito_producto) }}" method="POST" class="flex rounded-lg border border-gray-300 overflow-hidden bg-gray-50 h-9 w-28 mx-auto">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" name="action" value="decrease" class="w-8 bg-transparent hover:bg-gray-200 text-gray-600 font-bold transition-colors cursor-pointer outline-none">-</button>
                                                        <input type="number" name="quantity" value="{{ $item->cantidad }}" min="1" class="w-full text-center bg-white border-none text-gray-800 text-xs font-semibold focus:ring-0 outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" readonly>
                                                        <button type="submit" name="action" value="increase" class="w-8 bg-transparent hover:bg-gray-200 text-gray-600 font-bold transition-colors cursor-pointer outline-none">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-medium">
                                                ${{ number_format($item->precio_unitario, 2) }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-semibold">
                                                ${{ number_format($item->precio_unitario * $item->cantidad, 2) }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <form action="{{ route('user.carrito.remove', $item->id_carrito_producto) }}" method="POST" class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition-all cursor-pointer">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="pt-2">
                        <a href="{{ route('productos.search') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-dark transition-colors">
                            <i class="fas fa-arrow-left text-xs"></i> Continuar comprando
                        </a>
                    </div>
                </div>
                
                {{-- Solo la parte modificada del carrito.blade.php (sección del resumen) --}}
<div class="lg:col-span-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Resumen del Pedido</h2>
    
    <div class="space-y-3 text-sm">
        <div class="flex justify-between text-gray-600">
            <span>Subtotal (con IVA incluido)</span>
            <span class="font-semibold text-gray-900">${{ number_format($subtotalConIva, 2) }}</span>
        </div>
        
        <div class="flex justify-between text-gray-600">
            <span>Subtotal (sin IVA)</span>
            <span class="font-semibold text-gray-900">${{ number_format($subtotalSinIva, 2) }}</span>
        </div>
        
        <div class="flex justify-between text-gray-600 border-t border-gray-100 pt-2">
            <span>IVA ({{ $ivaFactor * 100 }}%)</span>
            <span class="font-semibold text-gray-900">${{ number_format($ivaTotal, 2) }}</span>
        </div>
        
        <div class="flex justify-between text-gray-600">
            <span>Envío</span>
            <span class="font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded text-xs">Gratis</span>
        </div>
        
        <div class="border-t border-gray-200 pt-4 flex justify-between text-lg font-bold text-gray-900">
            <span>Total a pagar</span>
            <span class="text-xl text-primary font-extrabold">${{ number_format($total, 2) }}</span>
        </div>
    </div>
    
    <form id="checkout-form" action="{{ route('user.crear.pedido') }}" method="POST" class="m-0 p-0">
        @csrf
        <button type="submit" id="checkout-button" class="w-full h-12 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer">
            Proceder al pago <i class="fas fa-credit-card text-xs ml-1"></i>
        </button>
    </form>
</div>
                
            </div>
        @endif
    </main>

    <footer class="bg-gray-900 text-white mt-auto border-t border-gray-800">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="footer-column">
                    <h3 class="text-xl font-bold mb-4 tracking-tight">TechZone</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Tu tienda de confianza para hardware y componentes de computación de alto rendimiento.</p>
                </div>
                <div class="footer-column">
                    <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-sm p-0 m-0">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Productos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Sobre Nosotros</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Categorías</h4>
                    <ul class="space-y-2 text-sm p-0 m-0">
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Electrónica</a></li>
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