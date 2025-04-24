<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Dirección - TiendaOnline</title>
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
          <!-- Formulario de edición de dirección -->
          <div class="profile-edit">
            <h1>Editar Dirección</h1>
            <form action="{{ route('user.direccion-actualizar') }}" method="POST">
              @csrf
              @method("PUT")
              
              <label for="calle">Calle:</label>
              <input
                  type="text"
                  id="calle"
                  name="calle"
                  value="{{ Auth::user()->direccion->calle ?? old('calle', '') }}"
                  required
              />
          
              <label for="colonia">Colonia:</label>
              <input
                  type="text"
                  id="colonia"
                  name="colonia"
                  value="{{ Auth::user()->direccion->colonia ?? old('colonia', '') }}"
                  required
              />
          
              <label for="numeroExterior">Número exterior:</label>
              <input
                  type="text"
                  id="numeroExterior"
                  name="numeroExterior"
                  value="{{ Auth::user()->direccion->numeroExterior ?? old('numeroExterior', '') }}"
                  required
              />
          
              <label for="ciudad">Ciudad:</label>
              <input
                  type="text"
                  id="ciudad"
                  name="ciudad"
                  value="{{ Auth::user()->direccion->ciudad ?? old('ciudad', '') }}"
                  required
              />
          
              <label for="codigo_postal">Código Postal:</label>
              <input
                  type="text"
                  id="codigo_postal"
                  name="codigoPostal"
                  value="{{ Auth::user()->direccion->codigoPostal ?? old('codigoPostal', '') }}"
                  required
              />
          
              <label for="estado">Estado:</label>
              <input
                  type="text"
                  id="estado"
                  name="estado"
                  value="{{ Auth::user()->direccion->estado ?? old('estado', '') }}"
                  required
              />
          
              <label for="pais">País:</label>
              <input
                  type="text"
                  id="pais"
                  name="pais"
                  value="{{ Auth::user()->direccion->pais ?? old('pais', '') }}"
                  required
              />
          
              <button type="submit">Guardar Cambios</button>
          </form>
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
