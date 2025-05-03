<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalle del Pedido - TiendaOnline</title>
    <link rel="stylesheet" href="styles.css" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">TiendaOnline</a>
                <div class="search-bar">
                    <input type="text" placeholder="Buscar productos..." />
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                <nav class="nav-menu">
                    <ul>
                        <li>
                            <a>
                                <i class="fas fa-shopping-cart"></i> Carrito (0)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.dashboard-usuario') }}" class="active">
                                <i class="fas fa-user"></i> Mi Cuenta
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="profile-layout">
                <!-- Sidebar -->
                <aside class="client-sidebar">
                    <a href="{{ route('user.dashboard-usuario') }}" class="btn btn-primary">
                        <i class="fas fa-user"></i> Mi Perfil
                      </a>
                      <a href="{{ route('user.perfil') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar perfil
                      </a>
                      <a href="{{ route('user.direccion') }}" class="btn btn-primary">
                        <i class="fas fa-map-marker-alt"></i> Editar direccion
                      </a>
                      <a href="{{ route('user.pedidos') }}" class="btn btn-primary">
                        <i class="fas fa-box"></i> Mis pedidos
                      </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                </aside>

                <!-- Detalles del Pedido -->
                <div class="order-details-container">
                    <h1>Detalles del Pedido</h1>
                    <div class="order-summary">
                        <p><strong>Pedido:</strong> {{ $pedido['numero_pedido'] }}</p>
                        <p><strong>Fecha de Pedido:</strong> 
                            @if($pedido['fecha_pedido'] != 'No disponible')
                                {{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d/m/Y') }}
                            @else
                                {{ $pedido['fecha_pedido'] }}
                            @endif
                        </p>
                        <p>
                            <strong>Estado del envio:</strong>
                            <span class="status {{ strtolower($pedido['estado_envio']) }}">
                                {{ $pedido['estado_envio'] }}
                            </span>
                        </p>
                        <p>
                            <strong>Estado del Pago:</strong>
                            <span class="status {{ strtolower($pedido['estado_pago']) }}">
                                {{ $pedido['estado_pago'] }}
                            </span>
                        </p>
                        <p>
                            <strong>Fecha Estimada de Entrega:</strong> 
                            @if($pedido['fecha_estimada_entrega'] != 'No disponible')
                                {{ \Carbon\Carbon::parse($pedido['fecha_estimada_entrega'])->format('d/m/Y') }}
                            @else
                                {{ $pedido['fecha_estimada_entrega'] }}
                            @endif
                        </p>
                    </div>

                    <div class="shipping-info">
                        <h2>Dirección de Envío</h2>
                        <p><strong>Dirección:</strong> 
                            {{ $pedido['direccion_envio']['calle'] }} 
                            {{ $pedido['direccion_envio']['numero_exterior'] }}, 
                            {{ $pedido['direccion_envio']['colonia'] }}
                        </p>
                        <p><strong>Ciudad:</strong> {{ $pedido['direccion_envio']['ciudad'] }}</p>
                        <p><strong>Código Postal:</strong> {{ $pedido['direccion_envio']['codigo_postal'] }}</p>
                        <p><strong>Estado:</strong> {{ $pedido['direccion_envio']['estado'] }}</p>
                        <p><strong>País:</strong> {{ $pedido['direccion_envio']['pais'] }}</p>
                    </div>

                    <div class="product-list">
                        <h2>Productos</h2>
                        <table class="products-table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido['productos'] as $producto)
                                <tr>
                                    <td>{{ $producto['nombre'] }}</td>
                                    <td>{{ $producto['cantidad'] }}</td>
                                    <td>${{ number_format($producto['precio_unitario'], 2) }}</td>
                                    <td>${{ number_format($producto['total'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="order-total">
                        <h2>Total del Pedido</h2>
                        <p><strong>Subtotal:</strong> ${{ number_format($pedido['subtotal'], 2) }}</p>
                        <p class="total-amount">
                            <strong>Total:</strong> ${{ number_format($pedido['total_pedido'], 2) }}
                        </p>
                    </div>
                </div>
            </div>
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
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Productos</a></li>
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Categorías</h4>
                    <ul>
                        <li><a href="#">Electrónica</a></li>
                        <li><a href="#">Ropa</a></li>
                        <li><a href="#">Hogar</a></li>
                        <li><a href="#">Deportes</a></li>
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