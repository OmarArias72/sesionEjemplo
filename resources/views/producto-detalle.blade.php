<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechZone - {{ $producto->nombre_producto }}</title>
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  {{-- Configuración CDN complementaria para asegurar soporte de colores extendidos --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
      tailwind.config = {
          theme: {
              extend: {
                  colors: {
                      primary: '#1a56db',
                      'primary-dark': '#1e429f',
                      'primary-light': '#e1effe',
                  }
              }
          }
      }
  </script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

  <!-- ========================================
       HEADER & MENSAJES DEL SISTEMA
  ========================================= -->
  <header class="bg-primary shadow-lg sticky top-0 z-50">
      <div class="container mx-auto px-4 py-4">
          <div class="flex flex-wrap justify-between items-center gap-4">
              <a href="{{ route('home') }}" class="text-white text-2xl font-bold hover:text-blue-200 transition-colors">TechZone</a>
              
              <!-- Barra de búsqueda mejorada e integrada -->
              <div class="flex-1 max-w-md mx-4">
                  <form action="#" method="GET" class="relative flex items-center bg-white rounded-lg border-2 border-blue-700/30 overflow-hidden focus-within:border-white focus-within:ring-2 focus-within:ring-blue-300 transition-all shadow-sm">
                      <input type="text" placeholder="Buscar productos..." class="w-full bg-transparent px-4 py-2 text-gray-800 placeholder-gray-400 border-none outline-none focus:ring-0 text-sm" />
                      <button type="submit" class="bg-blue-800 hover:bg-primary-dark text-white h-full px-5 flex items-center justify-center transition-colors border-l border-blue-700/20 cursor-pointer" style="align-self: stretch;">
                          <i class="fas fa-search text-xs tracking-wide"></i>
                      </button>
                  </form>
              </div>
              
              <nav class="nav-menu">
                  <ul class="flex space-x-6 items-center">
                        @auth
                            <li>
                                <a href="{{route('user.carrito.ver')}}" class="text-white hover:text-blue-200 transition flex items-center gap-2 font-medium text-sm">
                                    <i class="fas fa-shopping-cart"></i> Carrito ({{ auth()->user()->carritoActivoProductosCount() }})
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.dashboard-usuario') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 font-semibold text-sm border-b-2 border-white pb-0.5">
                                    <i class="fas fa-user"></i> Mi Cuenta
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 text-sm font-medium">
                                    <i class="fas fa-shopping-cart"></i> Carrito (0)
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition flex items-center gap-2 text-sm font-medium">
                                    <i class="fas fa-user"></i> Iniciar Sesión
                                </a>
                            </li>
                        @endauth
                  </ul>
              </nav>
          </div>
      </div>
  </header>

  <!-- Contenedor flotante para Alertas (Debajo del Header fijo) -->
  <div class="container mx-auto px-4 mt-4">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                <strong class="block font-semibold mb-1"><i class="fas fa-exclamation-triangle mr-1.5"></i> Se encontraron los siguientes errores:</strong>
                <ul class="list-disc list-inside text-sm space-y-0.5 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
  </div>

  <!-- ========================================
       BREADCRUMBS
  ========================================= -->
  <div class="bg-white border-b border-gray-200/80 py-3 mt-2">
      <div class="container mx-auto px-4">
          <ul class="flex flex-wrap items-center gap-2 text-xs font-medium text-gray-500">
              <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Inicio</a></li>
              <li class="after:content-['/'] after:ml-2 after:text-gray-300"><a href="{{ route('productos.search') }}" class="hover:text-primary transition-colors">Productos</a></li>
              <li class="after:content-['/'] after:ml-2 after:text-gray-300">
                  <a href="{{ route('productos.filtrados', ['categories[]' => $producto->categorias->id_categoria]) }}" class="hover:text-primary transition-colors">
                      {{ $producto->categorias->nombre_categoria }}
                  </a>
              </li>
              <li id="breadcrumb-product-title" class="text-gray-800 font-semibold truncate max-w-[200px] sm:max-w-xs">{{ $producto->nombre_producto }}</li>
          </ul>
      </div>
  </div>

  <!-- ========================================
       PRODUCT DETAIL SECTOR
  ========================================= -->
  <main class="container mx-auto px-4 py-8">
      <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
          
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">
              
              <!-- Galería de Imágenes (Columnas: 5 de 12) -->
              <div class="lg:col-span-5 space-y-4" id="images">
                  <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/50 flex flex-col items-center justify-center relative min-h-[300px] sm:min-h-[400px]">
                      <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="{{ $producto->nombre_producto }}" id="main-image" class="max-h-[350px] object-contain mix-blend-multiply transition-all duration-300">
                      
                      <button id="reset-image-btn" class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg shadow-sm transition-all cursor-pointer">
                          <i class="fas fa-undo-alt text-gray-400"></i> Restaurar original
                      </button>
                  </div>
                  
                  <!-- Miniaturas -->
                  <div class="flex flex-wrap gap-3" id="thumbnails">
                      @if($producto->url_imagen1)
                          <img src="{{ asset('imagenes/' . $producto->url_imagen1) }}" alt="Miniatura 1" 
                              class="product-thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-primary/50 transition-all bg-gray-50"
                              data-full-image="{{ asset('imagenes/' . $producto->url_imagen1) }}">
                      @endif
                      @if($producto->url_imagen2)
                          <img src="{{ asset('imagenes/' . $producto->url_imagen2) }}" alt="Miniatura 2" 
                              class="product-thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-primary/50 transition-all bg-gray-50"
                              data-full-image="{{ asset('imagenes/' . $producto->url_imagen2) }}">
                      @endif
                      @if($producto->url_imagen3)
                          <img src="{{ asset('imagenes/' . $producto->url_imagen3) }}" alt="Miniatura 3" 
                              class="product-thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-primary/50 transition-all bg-gray-50"
                              data-full-image="{{ asset('imagenes/' . $producto->url_imagen3) }}">
                      @endif
                  </div>
              </div>
              
              <!-- Información de Compra (Columnas: 7 de 12) -->
              <div class="lg:col-span-7 space-y-6">
                  <div>
                      <span class="inline-flex items-center bg-blue-50 text-primary text-xs font-bold px-2.5 py-1 rounded-md mb-2">Garantía Oficial</span>
                      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight" id="product-title">{{ $producto->nombre_producto }}</h1>
                  </div>
                  
                  <!-- Precios -->
                  <div class="flex items-baseline gap-3 border-y border-gray-100 py-4">
                      <span class="text-3xl font-extrabold text-gray-900 tracking-tight" id="product-price">${{ number_format($producto->precio, 2) }}</span>
                      @if($producto->precio_anterior)
                          <span class="text-lg text-gray-400 line-through font-medium" id="product-price-old">${{ number_format($producto->precio_anterior, 2) }}</span>
                          <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-0.5 rounded" id="product-discount">
                              {{ round((($producto->precio_anterior - $producto->precio) / $producto->precio_anterior) * 100) }}% OFF
                          </span>
                      @endif
                  </div>
                  
                  <!-- Descripción Corta -->
                  <div class="text-sm text-gray-600 leading-relaxed" id="product-description">
                      <p>{{ $producto->descripcion }}</p>
                  </div>
                  
                  <!-- Estado de Stock e indicador Visual -->
                  <div class="space-y-2" id="product-stock">
                      <div class="flex justify-between items-center text-xs font-semibold text-gray-500">
                          <span>Disponibilidad de Inventario:</span>
                          <span class="{{ $producto->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                              @if($producto->stock > 10)
                                  Disponible ({{ $producto->stock }} unidades)
                              @elseif($producto->stock > 0)
                                  Últimas unidades ({{ $producto->stock }} disponibles)
                              @else
                                  Agotado
                              @endif
                          </span>
                      </div>
                      <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                          @php $stockPercentage = min(100, ($producto->stock / 100) * 100); @endphp
                          <div class="h-full rounded-full transition-all duration-500 {{ $producto->stock <= 5 ? 'bg-red-500' : ($producto->stock <= 15 ? 'bg-amber-500' : 'bg-green-500') }}" id="stock-progress" style="width: {{ $stockPercentage }}%;"></div>
                      </div>
                  </div>
                  
                  <!-- Bloque de Acciones de Compra -->
                  <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center pt-2">
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden bg-gray-50 h-12 w-full sm:w-32 shrink-0">
                            <button class="w-10 bg-transparent hover:bg-gray-200 text-gray-600 font-bold transition-colors cursor-pointer outline-none" id="btn-decrease">-</button>
                            <input type="number" value="1" min="1" max="{{ $producto->stock }}" id="quantity-input" name="cantidad" class="w-full text-center bg-white border-none text-gray-800 font-semibold focus:ring-0 outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button class="w-10 bg-transparent hover:bg-gray-200 text-gray-600 font-bold transition-colors cursor-pointer outline-none" id="btn-increase">+</button>
                        </div>
                        
                        <form action="{{ route('user.carrito.agregar') }}" method="POST" class="flex-1 w-full m-0 p-0">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                            <input type="hidden" name="cantidad" id="cantidad-hidden" value="1">
                            
                            <button type="submit" class="w-full h-12 bg-primary hover:bg-primary-dark text-white font-bold px-6 rounded-lg shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed disabled:shadow-none" id="btn-add-cart" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart text-sm"></i> 
                                {{ $producto->stock <= 0 ? 'Agotado' : 'Añadir al carrito' }}
                            </button>
                        </form>
                  </div>
                  
                  <!-- Beneficios de Tienda -->
                  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 border-t border-gray-100 pt-6" id="product-benefits">
                      <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                          <i class="fas fa-truck text-primary text-lg"></i>
                          <span class="text-xs font-medium text-gray-600 leading-tight">Envío gratis desde $50</span>
                      </div>
                      <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                          <i class="fas fa-shield-alt text-primary text-lg"></i>
                          <span class="text-xs font-medium text-gray-600 leading-tight">Garantía de 2 años</span>
                      </div>
                      <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                          <i class="fas fa-undo text-primary text-lg"></i>
                          <span class="text-xs font-medium text-gray-600 leading-tight">30 días de devolución</span>
                      </div>
                  </div>
                  
                  <!-- Compartir Redes -->
                  <div class="flex items-center gap-3 text-sm text-gray-500 font-medium" id="product-share">
                      <span>Compartir:</span>
                      <button class="w-8 h-8 rounded-full border border-gray-300 hover:bg-gray-100 text-gray-500 flex items-center justify-center transition-colors cursor-pointer">
                          <i class="fas fa-share-alt text-xs"></i>
                      </button>
                  </div>
              </div>
          </div>
          
          <!-- Fichas Técnicas / Detalles Inferiores -->
          <div class="mt-12 border-t border-gray-200 pt-8 product-tabs">
              <div class="border-b border-gray-200 flex">
                  <button class="px-5 py-2.5 font-bold text-sm text-primary border-b-2 border-primary outline-none tab-btn active" data-tab="detalles">Características Principales</button>
              </div>
              
              <div class="py-6 tab-content">
                  <div class="tab-pane active" id="tab-detalles">
                      <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 list-none p-0 m-0 text-sm text-gray-600" id="product-features">
                          <li class="flex items-center gap-2 py-1.5 border-b border-gray-100"><i class="fas fa-check text-green-500 text-xs"></i> <span>Componente de alta fidelidad certificado</span></li>
                          <li class="flex items-center gap-2 py-1.5 border-b border-gray-100"><i class="fas fa-check text-green-500 text-xs"></i> <span>Categoría: <span class="font-semibold text-gray-800">{{ $producto->categorias->nombre_categoria }}</span></span></li>
                          <li class="flex items-center gap-2 py-1.5 border-b border-gray-100"><i class="fas fa-check text-green-500 text-xs"></i> <span>Estado comercial: <span class="font-semibold text-gray-800">{{ $producto->estado }}</span></span></li>
                          <li class="flex items-center gap-2 py-1.5 border-b border-gray-100"><i class="fas fa-check text-green-500 text-xs"></i> <span>Empaque de protección premium incluido</span></li>
                      </ul>
                  </div>
              </div>
          </div>
          
      </div>
  </main>

  <!-- ========================================
       FOOTER
  ========================================= -->
  <footer class="bg-gray-900 text-white mt-16 border-t border-gray-800">
      <div class="container mx-auto px-4 py-12">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
              <div class="footer-column">
                  <h3 class="text-xl font-bold mb-4 tracking-tight">TechZone</h3>
                  <p class="text-gray-400 text-sm leading-relaxed">Tu tienda tecnológica global y de confianza para soluciones informáticas avanzadas.</p>
              </div>
              <div class="footer-column">
                  <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Enlaces Rápidos</h4>
                  <ul class="space-y-2 text-sm p-0 m-0">
                      <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                      <li><a href="" class="text-gray-400 hover:text-white transition-colors">Productos</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Sobre Nosotros</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contacto</a></li>
                  </ul>
              </div>
              <div class="footer-column">
                  <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Categorías</h4>
                  <ul class="space-y-2 text-sm p-0 m-0">
                      <li><a href="" class="text-gray-400 hover:text-white transition-colors">Electrónica</a></li>
                      <li><a href="" class="text-gray-400 hover:text-white transition-colors">Ropa</a></li>
                      <li><a href="" class="text-gray-400 hover:text-white transition-colors">Hogar</a></li>
                      <li><a href="" class="text-gray-400 hover:text-white transition-colors">Deportes</a></li>
                  </ul>
              </div>
              <div class="footer-column">
                  <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-200">Contacto</h4>
                  <address class="not-italic text-sm text-gray-400 space-y-2">
                      <p><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i> Calle Principal 123</p>
                      <p><i class="fas fa-city mr-2 text-gray-500"></i> Ciudad, País</p>
                      <p><i class="fas fa-envelope mr-2 text-gray-500"></i> info@TechZone.com</p>
                      <p><i class="fas fa-phone mr-2 text-gray-500"></i> +123 456 7890</p>
                  </address>
              </div>
          </div>
          <div class="text-center pt-8 mt-8 border-t border-gray-800 text-xs text-gray-500">
              <p>&copy; {{ date('Y') }} TechZone. Todos los derechos reservados.</p>
          </div>
      </div>
  </footer>
  
  <!-- INTERACTIVIDAD JS (Mantenida intacta) -->
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const btnDecrease = document.getElementById('btn-decrease');
          const btnIncrease = document.getElementById('btn-increase');
          const quantityInput = document.getElementById('quantity-input');
          const hiddenQuantity = document.getElementById('cantidad-hidden');
          
          btnDecrease.addEventListener('click', function() {
              let value = parseInt(quantityInput.value);
              if (value > 1) {
                  quantityInput.value = value - 1;
                  if(hiddenQuantity) hiddenQuantity.value = quantityInput.value;
              }
          });
          
          btnIncrease.addEventListener('click', function() {
              let value = parseInt(quantityInput.value);
              let max = parseInt(quantityInput.max);
              if (value < max) {
                  quantityInput.value = value + 1;
                  if(hiddenQuantity) hiddenQuantity.value = quantityInput.value;
              }
          });
          
          const addToCartBtn = document.getElementById('btn-add-cart');
          if (addToCartBtn) {
              addToCartBtn.addEventListener('click', function(e) {
                  if (this.disabled) {
                      e.preventDefault();
                      return;
                  }
                  const hiddenQuantity = document.getElementById('cantidad-hidden');
                  const quantityInput = document.getElementById('quantity-input');
                  if (hiddenQuantity) hiddenQuantity.value = quantityInput.value;
              });
          }

        const thumbnails = document.querySelectorAll('.product-thumbnail');
        const mainImage = document.getElementById('main-image');
        
        function checkImageExists(url, callback) {
            const img = new Image();
            img.onload = function() { callback(true); };
            img.onerror = function() { callback(false); };
            img.src = url;
        }
        
        thumbnails.forEach(thumbnail => {
            checkImageExists(thumbnail.src, function(exists) {
                if (!exists) {
                    thumbnail.style.display = 'none';
                }
            });
            
            thumbnail.addEventListener('click', function() {
                const fullImageUrl = this.getAttribute('data-full-image');
                if (fullImageUrl) {
                    mainImage.src = fullImageUrl;
                    thumbnails.forEach(t => {
                        t.classList.remove('border-primary', 'border-2');
                        t.classList.add('border-transparent');
                    });
                    this.classList.remove('border-transparent');
                    this.classList.add('border-primary', 'border-2');
                }
            });
        });
        
        setTimeout(() => {
            const firstVisibleThumbnail = Array.from(thumbnails).find(t => 
                t.style.display !== 'none' && 
                window.getComputedStyle(t).display !== 'none'
            );
            if (firstVisibleThumbnail) {
                firstVisibleThumbnail.classList.remove('border-transparent');
                firstVisibleThumbnail.classList.add('border-primary', 'border-2');
            }
        }, 100);

        const resetImageBtn = document.getElementById('reset-image-btn');
        const originalImageUrl = "{{ asset('imagenes/' . $producto->url_imagen) }}";

        if (resetImageBtn) {
            resetImageBtn.addEventListener('click', function() {
                mainImage.src = originalImageUrl;
                thumbnails.forEach(t => {
                    t.classList.remove('border-primary', 'border-2');
                    t.classList.add('border-transparent');
                });
            });
        }
    });
  </script>
</body>
</html>