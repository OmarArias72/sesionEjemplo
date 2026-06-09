<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Productos Admin</title>
    {{-- Tailwind CSS v3 CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Archivo CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Personalización de la paleta corporativa --}}
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
<body class="bg-transparent font-sans antialiased text-gray-800 p-1">

    <!-- Contenedor responsivo de la tabla -->
    <div class="w-full overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full border-collapse text-left text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th scope="col" class="px-6 py-4 font-semibold text-xs uppercase tracking-wider text-gray-500">Imagen</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-xs uppercase tracking-wider text-gray-500">Producto</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-xs uppercase tracking-wider text-gray-500">Precio</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-xs uppercase tracking-wider text-gray-500">Stock</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-xs uppercase tracking-wider text-gray-500">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($productos as $producto)
                <tr class="hover:bg-gray-50/75 transition-colors even:bg-gray-50/30">
                    <!-- Imagen -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-12 h-12 rounded-md overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0">
                            <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" 
                                 alt="{{ $producto->nombre_producto }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </td>
                    <!-- Nombre -->
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $producto->nombre_producto }}
                    </td>
                    <!-- Precio -->
                    <td class="px-6 py-4 text-gray-600 font-medium whitespace-nowrap">
                        ${{ number_format($producto->precio, 2) }}
                    </td>
                    <!-- Stock badge condicional -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            // Mapeo de estilos semánticos definidos en CSS a utilidades Tailwind
                            $badgeStyles = 'bg-green-100 text-green-800 border-green-200'; // High
                            if($producto->stock <= 5) {
                                $badgeStyles = 'bg-red-100 text-red-800 border-red-200'; // Low
                            } elseif($producto->stock <= 15) {
                                $badgeStyles = 'bg-amber-100 text-amber-800 border-amber-200'; // Medium
                            }
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeStyles }}">
                            {{ $producto->stock }} u.
                        </span>
                    </td>
                    <!-- Estado badge -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $producto->estado ? 'bg-green-100 text-green-800 border-green-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $producto->estado ? 'bg-green-600' : 'bg-amber-500' }}"></span>
                            {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Barra de Paginación -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 px-4 py-4 mt-4 bg-white rounded-lg border border-gray-200 shadow-sm">
        <span class="text-sm text-gray-600 font-medium">
            Mostrando <span class="text-gray-900 font-semibold">{{ $productos->firstItem() }}</span> al <span class="text-gray-900 font-semibold">{{ $productos->lastItem() }}</span> de <span class="text-gray-900 font-semibold">{{ $productos->total() }}</span> productos
        </span>
        
        <div class="inline-flex rounded-lg border border-gray-200 shadow-sm bg-white overflow-hidden">
            {{-- Botón Anterior --}}
            <button class="px-4 py-2 text-sm font-medium border-r border-gray-200 transition-colors {{ $productos->onFirstPage() ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50 cursor-pointer' }}" 
                onclick="changePage({{ $productos->currentPage() - 1 }})" 
                {{ $productos->onFirstPage() ? 'disabled' : '' }}>
                <i class="fas fa-chevron-left mr-1.5 text-xs"></i> Anterior
            </button>

            {{-- Números de página --}}
            @for ($i = 1; $i <= $productos->lastPage(); $i++)
                <button class="px-4 py-2 text-sm font-semibold transition-colors border-r border-gray-200 last:border-r-0 cursor-pointer {{ $i == $productos->currentPage() ? 'bg-primary text-white hover:bg-primary-dark' : 'text-gray-700 hover:bg-gray-50' }}" 
                    onclick="changePage({{ $i }})">
                    {{ $i }}
                </button>
            @endfor

            {{-- Botón Siguiente --}}
            <button class="px-4 py-2 text-sm font-medium transition-colors {{ !$productos->hasMorePages() ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50 cursor-pointer' }}" 
                onclick="changePage({{ $productos->currentPage() + 1 }})" 
                {{ !$productos->hasMorePages() ? 'disabled' : '' }}>
                Siguiente <i class="fas fa-chevron-right ml-1.5 text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Script de comunicación con el Iframe Padre -->
    <script>
        function changePage(page) {
            const iframe = window.parent.document.querySelector('iframe');
            if (iframe) {
                const currentUrl = new URL(iframe.src);
                currentUrl.searchParams.set('page', page);
                iframe.src = currentUrl.toString();
            }
        }
    </script>
</body>
</html>