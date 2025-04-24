<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TiendaOnline - Mi Perfil</title>
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
              <li>
                <a href="carrito.html"
                  ><i class="fas fa-shopping-cart"></i> Carrito (0)</a
                >
              </li>
              <li>
                <a href="{{ route('user.dashboard-usuario') }}" class="active"
                  ><i class="fas fa-user"></i> Mi Cuenta</a
                >
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
          <!-- Sidebar de Cliente -->
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

          <!-- Contenido del Perfil -->
          <div class="profile-content">
            <h1>Mi Perfil</h1>
            <div class="profile-card">
              <h2>Información Personal</h2>
              <p><strong>Nombre:</strong> {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
              <p><strong>Correo Electrónico:</strong> {{ Auth::user()->email }}</p>
              <p><strong>Teléfono:</strong> {{ Auth::user()->telefono }}</p>
              {{-- <p><strong>Fecha de Nacimiento:</strong> 15/05/1985</p> --}}
            </div>
            <div class="profile-card">
                <h2>Dirección de Entrega</h2>
                @if(Auth::user()->direccion)
                    <p><strong>Dirección:</strong> 
                        {{ Auth::user()->direccion->calle ?? 'No especificada' }} 
                        {{ Auth::user()->direccion->numeroExterior ?? '' }}
                    </p>
                    <p><strong>Colonia:</strong> {{ Auth::user()->direccion->colonia ?? 'No especificada' }}</p>
                    <p><strong>Ciudad:</strong> {{ Auth::user()->direccion->ciudad ?? 'No especificada' }}</p>
                    <p><strong>Código Postal:</strong> {{ Auth::user()->direccion->codigoPostal ?? 'No especificado' }}</p>
                    <p><strong>Estado:</strong> {{ Auth::user()->direccion->estado ?? 'No especificado' }}</p>
                    <p><strong>País:</strong> {{ Auth::user()->direccion->pais ?? 'No especificado' }}</p>
                @else
                    <p class="text-warning">No has registrado una dirección de entrega</p>
                    <a href="{{ route('user.direccion') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Agregar dirección
                    </a>
                @endif
            </div>
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
