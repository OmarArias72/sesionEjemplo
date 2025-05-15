<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Carrito de Compras</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">

        <!-- Sección para mostrar errores -->
        @if(session('error'))
            <div class="alert alert-error mb-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">TiendaOnline</a>
                
                <div class="search-bar">
                    <input type="text" placeholder="Buscar productos...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                
                <nav class="nav-menu">
                    <ul>
                        <li><a href="{{ route('user.carrito.ver') }}" class="active"><i class="fas fa-shopping-cart"></i> Carrito ({{ $cartItems->count() }})</a></li>
                        <li><a href="#"><i class="fas fa-user"></i> Mi Cuenta</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Tu Carrito</h1>
            
            @if($cartItems->isEmpty())
                <div class="empty-cart">
                    <p>Tu carrito está vacío</p>
                    <a href="" class="btn-continue">
                        <i class="fas fa-arrow-right"></i> Comenzar a comprar
                    </a>
                </div>
            @else
                <div class="cart-layout">
                    <!-- Cart Items -->
                    <div class="cart-items">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="cart-product">
                                                    <div class="cart-product-img">
                                                        <img src="{{ asset('imagenes/' . $item->producto->url_imagen) ?? 'https://via.placeholder.com/80x80?text=Producto' }}" alt="{{ $item->producto->nombre_producto }}">
                                                    </div>
                                                    <div class="cart-product-info">
                                                        <a href="{{ route('productos.show', $item->producto->id_producto) }}" class="cart-product-name">{{ $item->producto->nombre_producto }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="quantity-selector">
                                                    <form action="{{ route('user.carrito.update', $item->id_carrito_producto) }}" method="POST" style="display: inline;">
                                                        
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" name="action" value="decrease" class="quantity-btn">-</button>
                                                        <input type="number" name="quantity" value="{{ $item->cantidad }}" min="1" class="quantity-input">
                                                        <button type="submit" name="action" value="increase" class="quantity-btn">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>${{ number_format($item->precio_unitario, 2) }}</td>
                                            <td>${{ number_format($item->precio_unitario * $item->cantidad, 2) }}</td>
                                            <td>
                                                <form action="{{ route('user.carrito.remove', $item->id_carrito_producto) }}" method="POST" style="display: inline;">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-remove">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="cart-actions">
                            <a href="{{ route('productos.search') }}" class="btn-continue">
                                <i class="fas fa-arrow-right"></i> Continuar comprando
                            </a>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h2>Resumen del Pedido</h2>
                        
                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotalSinIva, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Envío</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <div class="summary-item">
                            <span>Impuestos (16%)</span>
                            <span>${{ $ivaTotal }}</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <form id="checkout-form" action="{{ route('user.crear.pedido') }}" method="POST">
                            @csrf
                            <button type="submit" id="checkout-button" class="btn btn-primary btn-checkout">
                            Proceder al pago
                            </button>
                        </form>
                        
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>TiendaOnline</h3>
                    <p>Tu tienda de confianza para compras en línea.</p>
                </div>
                <div class="footer-column">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="">Productos</a></li>
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Categorías</h4>
                    <ul>
                        <li><a href="">Electrónica</a></li>
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
                <p>&copy; {{ date('Y') }} TiendaOnline. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>