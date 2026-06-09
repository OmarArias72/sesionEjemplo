<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Perfil - TechZone</title>
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
                
                <!-- Barra de búsqueda integrada con los colores del sitio -->
                <div class="search-bar flex-1 max-w-md mx-4">
                    <form action="#" method="GET" class="relative flex items-center bg-white rounded-lg border-2 border-blue-700/30 overflow-hidden focus-within:border-white focus-within:ring-2 focus-within:ring-blue-300 transition-all shadow-sm">
                        <input type="text" 
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
            {{-- Layout con flexbox para sidebar izquierdo y contenido derecho --}}
            <div class="profile-layout flex flex-col md:flex-row gap-6">
                
                <!-- Sidebar (Izquierda) - con estilos de styles.css más Tailwind -->
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
                           class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-primary font-semibold border-l-4 border-primary">
                            <i class="fas fa-edit w-5"></i>
                            <span>Editar perfil</span>
                        </a>
                        
                        <a href="{{ route('user.direccion') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary transition group">
                            <i class="fas fa-map-marker-alt w-5 text-gray-500 group-hover:text-primary"></i>
                            <span>Editar dirección</span>
                        </a>
                        
                        <a href="{{ route('user.pedidos') }}" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary transition group">
                            <i class="fas fa-box w-5 text-gray-500 group-hover:text-primary"></i>
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

                <!-- Formulario de edición de perfil (Derecha) -->
                <div class="profile-edit flex-1 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-user-edit text-primary"></i>
                            Editar Perfil
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Actualiza tu información personal</p>
                    </div>
                    
                    <div class="p-6">
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('user.perfil-actualizar') }}" method="POST" class="space-y-5">
                            @csrf
                            @method("PUT")
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i> Nombre:
                                    </label>
                                    <input type="text" id="nombre" name="nombre" 
                                           value="{{ old('nombre', Auth::user()->nombre) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                           required />
                                </div>
                                
                                <div>
                                    <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i> Apellido:
                                    </label>
                                    <input type="text" id="apellido" name="apellido" 
                                           value="{{ old('apellido', Auth::user()->apellido) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                           required />
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-1 text-gray-400"></i> Correo Electrónico:
                                    </label>
                                    <input type="email" id="email" name="email" 
                                           value="{{ old('email', Auth::user()->email) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                           required />
                                </div>
                                
                                <div>
                                    <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone mr-1 text-gray-400"></i> Teléfono:
                                    </label>
                                    <input type="tel" id="telefono" name="telefono" 
                                           value="{{ old('telefono', Auth::user()->telefono) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                           required />
                                </div>
                                
                                <div>
                                    <label for="fecha_registro" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-calendar-alt mr-1 text-gray-400"></i> Miembro desde:
                                    </label>
                                    <input type="text" id="fecha_registro" 
                                           value="{{ Auth::user()->created_at ? \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y') : 'No disponible' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600"
                                           disabled />
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 mt-4">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-shield-alt text-primary text-lg mt-0.5"></i>
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            <span class="font-semibold">¿Necesitas cambiar tu contraseña?</span>
                                            <br>
                                            Para actualizar tu contraseña, por favor contacta al administrador o utiliza la opción de "¿Olvidaste tu contraseña?" en la página de inicio de sesión.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex gap-3 pt-4">
                                <button type="submit" 
                                        class="bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-2 rounded-lg transition flex items-center gap-2 shadow-md hover:shadow-lg">
                                    <i class="fas fa-save"></i>
                                    Guardar Cambios
                                </button>
                                
                                <a href="{{ route('user.dashboard-usuario') }}" 
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-lg transition flex items-center gap-2">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </a>
                            </div>
                        </form>
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