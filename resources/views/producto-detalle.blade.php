<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TiendaOnline - {{ $producto->nombre_producto }}</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
   @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <header class="header">
      <div class="container">
          <div class="header-content">
              <a href="{{ route('home') }}" class="logo">TiendaOnline</a>
              <div class="search-bar">
                  <input type="text" placeholder="Buscar productos...">
                  <button type="submit"><i class="fas fa-search"></i></button>
              </div>
              <nav class="nav-menu">
                  <ul>
                      <li><a href=""><i class="fas fa-shopping-cart"></i> Carrito (0)</a></li>
                      <li><a href="{{ route('login') }}"><i class="fas fa-user"></i> Iniciar Sesión</a></li>
                  </ul>
              </nav>
          </div>
      </div>
  </header>

  <!-- Breadcrumbs -->
  <div class="breadcrumbs">
      <div class="container">
          <ul>
              <li><a href="{{ route('home') }}">Inicio</a></li>
              <li><a href="">Productos</a></li>
              {{-- <li><a href="{{ route('productos.categoria', $producto->categorias->id_categoria) }}">{{ $producto->categorias->nombre_categoria }}</a></li>
              <li id="breadcrumb-product-title">{{ $producto->nombre_producto }}</li> --}}
          </ul>
      </div>
  </div>

  <!-- Product Detail -->
  <main class="main-content">
      <div class="container">
          <div class="product-detail">
              <div class="product-detail-grid">
                  <!-- Product Images -->
                  <div class="product-images" id="images">
                    <div class="product-main-image">
                        <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="{{ $producto->nombre_producto }}" id="main-image">
                    </div>
                    <div class="product-thumbnails" id="thumbnails">
                      <!-- Si tienes múltiples imágenes para el producto, puedes iterarlas aquí -->
                      <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="Miniatura 1" class="thumbnail">
                    </div>
                  </div>
                  
                  <!-- Product Info -->
                  <div class="product-info">
                      <h1 class="product-title" id="product-title">{{ $producto->nombre_producto }}</h1>
                      
                      <div class="product-price-container">
                          <span class="product-price" id="product-price">${{ number_format($producto->precio, 2) }}</span>
                          @if($producto->precio_anterior)
                          <span class="product-price-old" id="product-price-old">${{ number_format($producto->precio_anterior, 2) }}</span>
                          <span class="product-discount" id="product-discount">
                              {{ round((($producto->precio_anterior - $producto->precio) / $producto->precio_anterior) * 100) }}% OFF
                          </span>
                          @endif
                      </div>
                      
                      <div class="product-description" id="product-description">
                          <p>{{ $producto->descripcion }}</p>
                      </div>
                      
                      {{-- <div class="product-colors" id="product-colors">
                          <h3>Colores disponibles:</h3>
                          <div class="color-options" id="color-options">
                            <!-- Ejemplo de colores, puedes adaptarlo a tus necesidades -->
                            <button class="color-option">Negro</button>
                            <button class="color-option">Blanco</button>
                          </div>
                      </div> --}}
                      
                      <div class="product-stock" id="product-stock">
                          <div class="stock-bar">
                              @php
                                  $stockPercentage = min(100, ($producto->stock / 100) * 100);
                              @endphp
                              <div class="stock-progress" id="stock-progress" style="width: {{ $stockPercentage }}%;"></div>
                          </div>
                          <span id="stock-text">
                              @if($producto->stock > 10)
                                  Disponible ({{ $producto->stock }} unidades)
                              @elseif($producto->stock > 0)
                                  Últimas unidades ({{ $producto->stock }} disponibles)
                              @else
                                  Agotado
                              @endif
                          </span>
                      </div>
                      
                      <div class="product-actions">
                          <div class="quantity-selector">
                              <button class="quantity-btn" id="btn-decrease">-</button>
                              <input type="number" value="1" min="1" max="{{ $producto->stock }}" id="quantity-input" class="quantity-input">
                              <button class="quantity-btn" id="btn-increase">+</button>
                          </div>
                          <button class="btn btn-primary btn-add-cart" id="btn-add-cart" 
                                  {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                              <i class="fas fa-shopping-cart"></i> 
                              {{ $producto->stock <= 0 ? 'Agotado' : 'Añadir al carrito' }}
                          </button>
                      </div>
                      
                      <div class="product-benefits" id="product-benefits">
                          <div class="benefit">
                              <i class="fas fa-truck"></i>
                              <span>Envío gratis en pedidos superiores a $50</span>
                          </div>
                          <div class="benefit">
                              <i class="fas fa-shield-alt"></i>
                              <span>Garantía de 2 años</span>
                          </div>
                          <div class="benefit">
                              <i class="fas fa-undo"></i>
                              <span>30 días para devoluciones</span>
                          </div>
                      </div>
                      
                      <div class="product-share" id="product-share">
                          <span>Compartir:</span>
                          <div class="share-buttons">
                              <button class="share-btn">
                                  <i class="fas fa-share-alt"></i>
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
              
              <!-- Product Details Tabs -->
              <div class="product-tabs">
                  <div class="tabs-header">
                      <button class="tab-btn active" data-tab="detalles">Detalles</button>
                  </div>
                  
                  <div class="tab-content">
                      <div class="tab-pane active" id="tab-detalles">
                          <h3>Características principales</h3>
                          <ul class="product-features" id="product-features">
                              <!-- Puedes agregar características específicas del producto aquí -->
                              <li>Producto de alta calidad</li>
                              <li>Categoría: {{ $producto->categorias->nombre_categoria }}</li>
                              <li>Estado: {{ $producto->estado }}</li>
                              <!-- Agrega más características según sea necesario -->
                          </ul>
                      </div>
                  </div>
              </div>
              
              <!-- Related Products -->
              <section class="related-products">
                  <h2 class="section-title">Productos relacionados</h2>
                  {{-- <div class="products-grid">
                      <!-- Ejemplo de productos relacionados, puedes reemplazar con datos reales -->
                      @foreach($productosRelacionados as $relacionado)
                      <div class="product-card">
                          <div class="product-img">
                              <img src="{{ asset('storage/' . $relacionado->url_imagen) }}" alt="{{ $relacionado->nombre_producto }}">
                          </div>
                          <div class="product-info">
                              <h3>{{ $relacionado->nombre_producto }}</h3>
                              <p class="product-price">${{ number_format($relacionado->precio, 2) }}</p>
                              <div class="product-actions">
                                  <a href="{{ route('productos.show', $relacionado->id_producto) }}" class="btn-link">Ver detalles</a>
                                  <a href="#" class="btn btn-small">Añadir</a>
                              </div>
                          </div>
                      </div>
                      @endforeach
                  </div> --}}
              </section>
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
                      <li><a href="">Ropa</a></li>
                      <li><a href="">Hogar</a></li>
                      <li><a href="">Deportes</a></li>
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
  
  <script>
      // Script para manejar la interactividad de la página
      document.addEventListener('DOMContentLoaded', function() {
          // Manejo del selector de cantidad
          const btnDecrease = document.getElementById('btn-decrease');
          const btnIncrease = document.getElementById('btn-increase');
          const quantityInput = document.getElementById('quantity-input');
          
          btnDecrease.addEventListener('click', function() {
              let value = parseInt(quantityInput.value);
              if (value > 1) {
                  quantityInput.value = value - 1;
              }
          });
          
          btnIncrease.addEventListener('click', function() {
              let value = parseInt(quantityInput.value);
              let max = parseInt(quantityInput.max);
              if (value < max) {
                  quantityInput.value = value + 1;
              }
          });
          
          // Manejo de las miniaturas de imágenes
          const thumbnails = document.querySelectorAll('.thumbnail');
          const mainImage = document.getElementById('main-image');
          
          thumbnails.forEach(thumbnail => {
              thumbnail.addEventListener('click', function() {
                  mainImage.src = this.src;
              });
          });
          
          // Manejo de pestañas
          const tabButtons = document.querySelectorAll('.tab-btn');
          
          tabButtons.forEach(button => {
              button.addEventListener('click', function() {
                  // Remover clase active de todos los botones y paneles
                  tabButtons.forEach(btn => btn.classList.remove('active'));
                  document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
                  
                  // Agregar clase active al botón clickeado
                  this.classList.add('active');
                  
                  // Mostrar el panel correspondiente
                  const tabId = this.getAttribute('data-tab');
                  document.getElementById(`tab-${tabId}`).classList.add('active');
              });
          });
          
          // Manejo del botón "Añadir al carrito"
          const addToCartBtn = document.getElementById('btn-add-cart');
          if (addToCartBtn) {
              addToCartBtn.addEventListener('click', function() {
                  const productId = {{ $producto->id_producto }};
                  const quantity = parseInt(quantityInput.value);
                  
                  // Aquí puedes agregar la lógica para añadir al carrito
                  // Por ejemplo, usando AJAX para enviar los datos al servidor
                  alert(`Producto añadido al carrito: ${quantity} unidad(es)`);
              });
          }
      });
  </script>
</body>
</html>