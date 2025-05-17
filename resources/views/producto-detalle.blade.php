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
            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red;">
                    <strong>Se encontraron los siguientes errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mostrar mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success" style="color: green;">
                    {{ session('success') }}
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

  <!-- Breadcrumbs -->
  <div class="breadcrumbs">
      <div class="container">
          <ul>
              <li><a href="{{ route('home') }}">Inicio</a></li>
              <li><a href="{{ route('productos.search') }}">Productos</a></li>
              <li><a href="{{ route('productos.filtrados', ['categories[]' => $producto->categorias->id_categoria]) }}">{{ $producto->categorias->nombre_categoria }}</a></li>
                    <li id="breadcrumb-product-title">{{ $producto->nombre_producto }}</li>
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
                        <button id="reset-image-btn" class="mt-2 px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                            <i class="fas fa-undo-alt mr-1"></i> Restaurar imagen original
                        </button>
                    </div>
                    <div class="product-thumbnails flex space-x-2 mt-4" id="thumbnails">
                        @if($producto->url_imagen1)
                            <img src="{{ asset('imagenes/' . $producto->url_imagen1) }}" alt="Miniatura 1" 
                                class="product-thumbnail w-20 h-20 object-cover rounded cursor-pointer border-2 hover:border-blue-500 transition-all"
                                data-full-image="{{ asset('imagenes/' . $producto->url_imagen1) }}">
                        @endif
                        @if($producto->url_imagen2)
                            <img src="{{ asset('imagenes/' . $producto->url_imagen2) }}" alt="Miniatura 2" 
                                class="product-thumbnail w-20 h-20 object-cover rounded cursor-pointer border-2 hover:border-blue-500 transition-all"
                                data-full-image="{{ asset('imagenes/' . $producto->url_imagen2) }}">
                        @endif
                        @if($producto->url_imagen3)
                            <img src="{{ asset('imagenes/' . $producto->url_imagen3) }}" alt="Miniatura 3" 
                                class="product-thumbnail w-20 h-20 object-cover rounded cursor-pointer border-2 hover:border-blue-500 transition-all"
                                data-full-image="{{ asset('imagenes/' . $producto->url_imagen3) }}">
                        @endif
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
                                <input type="number" value="1" min="1" max="{{ $producto->stock }}" id="quantity-input" name="cantidad" class="quantity-input">
                                <button class="quantity-btn" id="btn-increase">+</button>
                            </div>
                            <form action="{{ route('user.carrito.agregar') }}" method="POST" class="inline-form">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                                <input type="hidden" name="cantidad" id="cantidad-hidden" value="1">
                                <button type="submit" class="btn btn-primary btn-add-cart" id="btn-add-cart" 
                                        {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart"></i> 
                                    {{ $producto->stock <= 0 ? 'Agotado' : 'Añadir al carrito' }}
                                </button>
                            </form>
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
              {{-- <section class="related-products">
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
                  </div>
              </section> --}}
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
          
          // Manejo del botón "Añadir al carrito"
            const addToCartBtn = document.getElementById('btn-add-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function(e) {
                    if (this.disabled) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Actualizar el valor de cantidad en el formulario antes de enviar
                    const form = this.closest('form');
                    const quantityInput = document.getElementById('quantity-input');
                    form.querySelector('input[name="cantidad"]').value = quantityInput.value;
                });
            }

          // Manejo mejorado de las miniaturas de imágenes
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainImage = document.getElementById('main-image');
        
        // Función para verificar si una imagen existe
        function checkImageExists(url, callback) {
            const img = new Image();
            img.onload = function() { callback(true); };
            img.onerror = function() { callback(false); };
            img.src = url;
        }
        
        // Procesar cada miniatura
        thumbnails.forEach(thumbnail => {
            // Verificar si la imagen existe realmente
            checkImageExists(thumbnail.src, function(exists) {
                if (!exists) {
                    thumbnail.style.display = 'none';
                }
            });
            
            // Configurar el evento click
            thumbnail.addEventListener('click', function() {
                const fullImageUrl = this.getAttribute('data-full-image');
                if (fullImageUrl) {
                    mainImage.src = fullImageUrl;
                    
                    // Resaltar la miniatura seleccionada
                    thumbnails.forEach(t => {
                        t.classList.remove('border-blue-500', 'border-2');
                        t.classList.add('border-transparent');
                    });
                    this.classList.remove('border-transparent');
                    this.classList.add('border-blue-500', 'border-2');
                }
            });
        });
        
        // Resaltar la primera miniatura visible al cargar
        setTimeout(() => {
            const firstVisibleThumbnail = Array.from(thumbnails).find(t => 
                t.style.display !== 'none' && 
                window.getComputedStyle(t).display !== 'none'
            );
            
            if (firstVisibleThumbnail) {
                firstVisibleThumbnail.classList.remove('border-transparent');
                firstVisibleThumbnail.classList.add('border-blue-500', 'border-2');
            }
        }, 100);
        //RESTAURAR IMAGEN ORIGINAL
        const resetImageBtn = document.getElementById('reset-image-btn');
        const originalImageUrl = "{{ asset('imagenes/' . $producto->url_imagen) }}";

        if (resetImageBtn) {
            resetImageBtn.addEventListener('click', function() {
                mainImage.src = originalImageUrl;
                
                // Quitar el resaltado de todas las miniaturas
                thumbnails.forEach(t => {
                    t.classList.remove('border-blue-500', 'border-2');
                    t.classList.add('border-transparent');
                });
            });
        }
        });
  </script>
</body>
</html>