<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis Pedidos - TiendaOnline</title>
    <link rel="stylesheet" href="styles.css" />
    @vite('resources/css/app.css')
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <div class="container">
        <div class="header-content">
          <a href="{{route('home')}}" class="logo">TiendaOnline</a>
          <div class="search-bar">
            <input type="text" placeholder="Buscar productos..." />
            <button type="submit"><i class="fas fa-search"></i></button>
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

    <!-- Main Content -->
    <main class="main-content">
      <div class="container">
        <div class="profile-layout">
          <!-- Sidebar -->
          <aside class="client-sidebar">
            {{-- <button href="{{route('user.dashboard-usuario')}}">
              <i class="fas fa-user"></i> Mi Perfil
            </button> --}}
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
            
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
              @csrf
              <button type="submit" class="logout-button">
                  <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
              </button>
            </form>
            {{-- <button onclick="location.href='index.html'">
              <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </button> --}}
          </aside>
          <!-- Contenedor de pedidos -->
          <div class="orders-container">
            <h1>Mis Pedidos</h1>
            <table class="admin-table">
              <thead>
                  <tr>
                      <th>Pedido</th>
                      <th>Fecha</th>
                      <th>Estado</th>
                      <th>Total</th>
                      <th>Detalles</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($pedidos as $pedido)
                  <tr>
                      <td class="order-id">{{ $pedido['numero_pedido'] }}</td>
                      <td>{{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d M Y') }}</td>
                      <td>
                          <span class="status-badge 
                              @if($pedido['estado'] == 'Completado') completed
                              @elseif($pedido['estado'] == 'Procesando') processing
                              @elseif($pedido['estado'] == 'Enviado') shipped
                              @elseif($pedido['estado'] == 'Cancelado') cancelled
                              @else pending @endif">
                              {{ $pedido['estado'] }}
                          </span>
                      </td>
                      <td>${{ number_format($pedido['total'], 2) }}</td>
                      <td>
                        @php
                            $pedidoId = str_replace('#ORD-', '', $pedido['numero_pedido']);
                        @endphp
                        
                        <a href="{{ route('user.pedidos-detalles', ['pedidoId' => $pedidoId]) }}"
                          class="btn btn-small btn-primary">
                            Ver Detalles
                        </a>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
          </div>
        </div>
        <!-- Paginación -->
        <div class="admin-pagination">
          <span class="pagination-info">
              Mostrando {{ $pedidos->firstItem() }}-{{ $pedidos->lastItem() }} de {{ $pedidos->total() }} pedidos
          </span>
          <div class="pagination">
              @if($pedidos->onFirstPage())
                  <button class="pagination-btn prev" disabled>Anterior</button>
              @else
                  <a href="{{ $pedidos->previousPageUrl() }}" class="pagination-btn prev">Anterior</a>
              @endif

              @foreach(range(1, $pedidos->lastPage()) as $page)
                  @if($page == $pedidos->currentPage())
                      <button class="pagination-btn active">{{ $page }}</button>
                  @else
                      <a href="{{ $pedidos->url($page) }}" class="pagination-btn">{{ $page }}</a>
                  @endif
              @endforeach

              @if($pedidos->hasMorePages())
                  <a href="{{ $pedidos->nextPageUrl() }}" class="pagination-btn next">Siguiente</a>
              @else
                  <button class="pagination-btn next" disabled>Siguiente</button>
              @endif
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
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
              <li><a href="index.html">Inicio</a></li>
              <li><a href="productos.html">Productos</a></li>
              <li><a href="#">Sobre Nosotros</a></li>
              <li><a href="#">Contacto</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h4>Categorías</h4>
            <ul>
              <li>
                <a href="productos.html?categoria=electronica">Electrónica</a>
              </li>
              <li><a href="productos.html?categoria=ropa">Ropa</a></li>
              <li><a href="productos.html?categoria=hogar">Hogar</a></li>
              <li><a href="productos.html?categoria=deportes">Deportes</a></li>
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
