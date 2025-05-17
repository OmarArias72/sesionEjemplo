<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TiendaOnline - Productos</title>
  <link rel="stylesheet" href="styles.css">
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

  <!-- Main Content -->
  <main class="main-content">
    <div class="container">
      <h1 class="page-title">Catálogo de Productos</h1>
      <div class="products-layout">
        <!-- Sidebar Filters -->
        <aside class="sidebar">
          <div class="filter-section">
            <div class="filter-header">
              <h2>Filtros</h2>
              <i class="fas fa-filter"></i>
            </div>
            <!-- Filtro de subcategorías -->
            <form id="filter-form" action="{{ route('productos.filtrados') }}" method="GET">
                <input type="hidden" name="query" value="{{ $query }}">
                
                <div class="filter-group">
                    <h3>Categorías</h3>
                    <div class="filter-options">
                        <div class="filter-option">
                            <input type="checkbox" id="category-all" name="category_all" 
                                  {{ empty(request('categories')) ? 'checked' : '' }}>
                            <label for="category-all">Todas</label>
                        </div>
                        @foreach($categorias as $categoria)
                        <div class="filter-option">
                            <input type="checkbox" id="category-{{ $categoria->id_categoria }}" 
                                  class="category-filter" name="categories[]" 
                                  value="{{ $categoria->id_categoria }}"
                                  {{ in_array($categoria->id_categoria, request('categories', [])) ? 'checked' : '' }}>
                            <label for="category-{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Filtro de Precio -->
                <div class="filter-group">
                    <h3>Precio</h3>
                    <div class="price-range">
                        <input type="number" name="min_price" placeholder="Min" class="price-input" 
                              value="{{ request('min_price') }}">
                        <span>-</span>
                        <input type="number" name="max_price" placeholder="Max" class="price-input"
                              value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="btn btn-filter">Aplicar</button>
                </div>
            </form>
            <!-- Filtro de Valoración -->
            {{-- <div class="filter-group">
              <h3>Valoración</h3>
              <div class="filter-options">
                <div class="filter-option">
                  <input type="checkbox" id="rating-5" class="rating-filter" value="5">
                  <label for="rating-5">5 estrellas o más</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="rating-4" class="rating-filter" value="4">
                  <label for="rating-4">4 estrellas o más</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="rating-3" class="rating-filter" value="3">
                  <label for="rating-3">3 estrellas o más</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="rating-2" class="rating-filter" value="2">
                  <label for="rating-2">2 estrellas o más</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="rating-1" class="rating-filter" value="1">
                  <label for="rating-1">1 estrella o más</label>
                </div>
              </div>
            </div> --}}
          </div>
        </aside>
        
        <!-- Products Grid -->
        <div class="products-container">
          <div class="products-header">
            <p>Mostrando productos</p>
            <select class="sort-select">
              <option>Ordenar por: Destacados</option>
              <option>Precio: Menor a Mayor</option>
              <option>Precio: Mayor a Menor</option>
              <option>Más Recientes</option>
            </select>
          </div>
          
        <!-- Products Grid -->
        <section class="category-section">
            <div class="products-grid">
                @forelse($productos as $producto)
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="{{ $producto->nombre_producto }}">
                    </div>
                    <div class="product-info">
                        <span class="product-category">{{ $producto->categorias->nombre_categoria }}</span>
                        <h3>{{ $producto->nombre_producto }}</h3>
                        <p class="product-price">${{ number_format($producto->precio, 2) }}</p>
                        <div class="product-actions">
                            <a href="{{ route('productos.show', $producto->id_producto) }}" class="btn-link">Ver detalles</a>
                            <a href="#" class="btn btn-small">Añadir</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="no-results">
                    <p>No se encontraron productos que coincidan con tu búsqueda.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Paginación -->
            @if($productos->hasPages())
            <div class="pagination">
                {{ $productos->links() }}
            </div>
            @endif
        </section>
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
            <li><a href="productos.html?categoria=electronica">Smartphones</a></li>
            <li><a href="productos.html?categoria=electronica">Laptops</a></li>
            <li><a href="productos.html?categoria=electronica">Tablets</a></li>
            <li><a href="productos.html?categoria=electronica">Televisores</a></li>
            <li><a href="productos.html?categoria=electronica">Cámaras</a></li>
            <li><a href="productos.html?categoria=electronica">Audio</a></li>
            <li><a href="productos.html?categoria=electronica">Accesorios</a></li>
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
  

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filter-form');
        const categoryAll = document.getElementById('category-all');
        const categoryFilters = document.querySelectorAll('.category-filter');
        
        // Manejar el checkbox "Todas"
        categoryAll.addEventListener('change', function() {
            if (this.checked) {
                categoryFilters.forEach(filter => {
                    filter.checked = false;
                });
            }
        });
        
        // Manejar cuando se selecciona una categoría específica
        categoryFilters.forEach(filter => {
            filter.addEventListener('change', function() {
                if (this.checked) {
                    categoryAll.checked = false;
                }
                
                // Verificar si no hay categorías seleccionadas
                const anyChecked = Array.from(categoryFilters).some(f => f.checked);
                if (!anyChecked) {
                    categoryAll.checked = true;
                }
            });
        });
        
        // Manejar el envío del formulario
        form.addEventListener('submit', function(e) {
            // Si "Todas" está marcada, asegurarse de que no se envíen categorías
            if (categoryAll.checked) {
                document.querySelectorAll('input[name="categories[]"]').forEach(input => {
                    input.disabled = true;
                });
            }
        });
    });
  </script>
</body>
</html>
