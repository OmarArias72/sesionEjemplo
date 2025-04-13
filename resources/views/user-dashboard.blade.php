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
          <a href="index.html" class="logo">TiendaOnline</a>

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
                <a href="perfil-usuario.html" class="active"
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
            <button onclick="location.href='perfil-usuario.html'">
              <i class="fas fa-user"></i> Mi Perfil
            </button>
            <button onclick="location.href='editar-perfil.html'">
              <i class="fas fa-edit"></i> Editar Perfil
            </button>
            <button onclick="location.href='editar-direccion.html'">
              <i class="fas fa-map-marker-alt"></i> Editar Dirección
            </button>
            <button onclick="location.href='mis-pedidos.html'">
              <i class="fas fa-box"></i> Ver Mis Pedidos
            </button>
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
              <p><strong>Nombre:</strong> Juan Pérez García</p>
              <p><strong>Correo Electrónico:</strong> juan.perez@ejemplo.com</p>
              <p><strong>Teléfono:</strong> +34 612 345 678</p>
              <p><strong>Fecha de Nacimiento:</strong> 15/05/1985</p>
            </div>
            <div class="profile-card">
              <h2>Dirección de Facturación</h2>
              <p><strong>Dirección:</strong> Calle Principal 123, Piso 4B</p>
              <p><strong>Ciudad:</strong> Madrid</p>
              <p><strong>Código Postal:</strong> 28001</p>
              <p><strong>País:</strong> España</p>
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
