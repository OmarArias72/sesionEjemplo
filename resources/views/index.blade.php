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
                <div class="category-card">
                    <div class="category-img">
                        <img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=2070=Electrónica" alt="Electrónica">
                    </div>
                    <div class="category-info">
                        <h3>Electrónica</h3>
                        <a href="productos.html" class="btn btn-primary">Ver productos</a>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="products">
        <div class="container">
            <h2 class="section-title">Productos Destacados</h2>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaft7wQlyBBqTNwJUoLssj9B6hM5BDGtVaew&se" alt="Smartphone XYZ">
                    </div>
                    <div class="product-info">
                        <h3>iPhone 15</h3>
                        <p class="product-price">$15,999.99</p>
                        <div class="product-actions">
                            <a href="producto-detalle.html?id=1" class="btn-link">Ver detalles</a>
                            <a href="#" class="btn btn-small">Añadir</a>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://cdsassets.apple.com/live/SZLF0YNV/images/sp/111339_sp818-mbp13touch-space-select-202005.png" alt="Laptop Pro">
                    </div>
                    <div class="product-info">
                        <h3>Laptop Pro</h3>
                        <p class="product-price">$1299.99</p>
                        <div class="product-actions">
                            <a href="producto-detalle.html?id=14" class="btn-link">Ver detalles</a>
                            <a href="#" class="btn btn-small">Añadir</a>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://m.media-amazon.com/images/I/31zTjUDn2oL._AC_SY450_.jpg" alt="Tablets Samsung.">
                    </div>
                    <div class="product-info">
                        <h3>Tablets Samsung.</h3>
                        <p class="product-price">$3,197.55</p>
                        <div class="product-actions">
                            <a href="producto-detalle.html?id=19" class="btn-link">Ver detalles</a>
                            <a href="#" class="btn btn-small">Añadir</a>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://m.media-amazon.com/images/I/61Q+fn3lcJL._AC_SY450_.jpg" alt="Televisor Samsung Crystal UHD CU7095 ">
                    </div>
                    <div class="product-info">
                        <h3>Televisor Samsung Crystal UHD CU7095 </h3>
                        <p class="product-price">$27,599.99</p>
                        <div class="product-actions">
                            <a href="producto-detalle.html?id=27" class="btn-link">Ver detalles</a>
                            <a href="#" class="btn btn-small">Añadir</a>
                        </div>
                    </div>
                </div>
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