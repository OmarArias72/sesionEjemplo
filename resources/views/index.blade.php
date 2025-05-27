<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Inicio</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{route('home')}}" class="logo">TiendaOnline</a>
                
                <div class="search-bar">
                    <form action="{{ route('productos.search') }}" method="GET">
                        <input type="text" name="query" placeholder="Buscar productos...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <nav class="nav-menu">
                    <ul>
                        
                        @auth
                        <li><a href="{{route('user.carrito.ver')}}"><i class="fas fa-shopping-cart"></i> Carrito (@auth{{ auth()->user()->carritoActivoProductosCount() }}@else 0 @endauth)</a></li>
                            <li>
                                <a href="{{ route('user.dashboard-usuario') }}" class="active">
                                    <i class="fas fa-user"></i> Mi Cuenta
                                </a>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}"><i class="fas fa-shopping-cart"></i> Carrito (0)</a></li>
                            <li><a href="{{ route('login') }}"><i class="fas fa-user"></i> Iniciar Sesión</a></li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Bienvenido a nuestra Tienda Online</h1>
                <p>Descubre los mejores productos con los mejores precios</p>
                <a href="productos.html" class="btn btn-primary">Ver Catálogo</a>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Categorías Destacadas</h2>
            <div class="categories-grid">
                @foreach($categoriasDestacadas as $categoria)
                <div class="category-card">
                    <div class="category-img">
                        @if($categoria->producto_destacado_imagen)
                            <img src="{{ $categoria->imagen_producto_destacado }}" alt="{{ $categoria->nombre_categoria }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text={{ urlencode($categoria->nombre_categoria) }}" alt="{{ $categoria->nombre_categoria }}">
                        @endif
                    </div>
                    <div class="category-info">
                        <h3>{{ $categoria->nombre_categoria }}</h3>
                        <p>{{ $categoria->descripcion }}</p>
                        <form action="{{ route('productos.filtrados') }}" method="GET" class="category-form">
                            <input type="hidden" name="categories[]" value="{{ $categoria->id_categoria }}">
                            <button type="submit" class="btn btn-primary">Ver productos</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="products">
        <div class="container">
            <h2 class="section-title">Productos Más Vendidos</h2>
            <div class="products-grid">
                @foreach($productosMasVendidos as $producto)
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="{{ $producto->nombre_producto }}">
                    </div>
                    <div class="product-info">
                        <h3>{{ $producto->nombre_producto }}</h3>
                        <p class="product-price">${{ number_format($producto->precio, 2) }}</p>
                        <p>Vendidos: {{ $producto->total_vendido }}</p>
                        <div class="product-actions">
                            <a href="{{ route('productos.show', $producto->id_producto) }}" class="btn-link">Ver detalles</a>
                            <form action="{{ route('user.carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                                
                                @auth
                                    <button type="submit" class="btn btn-small">Añadir</button>
                                @else
                                    <button type="button" class="btn btn-small" disabled title="Debes iniciar sesión para añadir productos al carrito">
                                        Añadir
                                    </button>
                                    <small class="text-muted d-block">Inicia sesión para comprar</small>
                                @endauth
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>TiendaOnline</h3>
                    <p>Tu tienda de confianza para compras en línea con los mejores precios y calidad garantizada.</p>
                </div>
                <div class="footer-column">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="productos.html">Productos</a></li>
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Categorías</h4>
                    <ul>
                        <li><a href="productos.html?categoria=electronica">Electrónica</a></li>
                        
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Contacto</h4>
                    <address>
                        <p>Calle Principal 123</p>
                        <p>Ciudad, País</p>
                        <p>Email: info@tiendaonline.com</p>
                        <p>Teléfono: +123 456 7890</p>
                    </address>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 TiendaOnline. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>