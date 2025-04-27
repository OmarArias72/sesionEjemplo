<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>
                    <div class="product-thumbnail">
                        <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="{{ $producto->nombre_producto }}">
                    </div>
                </td>
                <td>{{ $producto->nombre_producto }}</td>
                <td>${{ number_format($producto->precio, 2) }}</td>
                <td>
                    @php
                        $stockClass = 'high';
                        if($producto->stock <= 5) $stockClass = 'low';
                        elseif($producto->stock <= 15) $stockClass = 'medium';
                    @endphp
                    <span class="stock-badge {{ $stockClass }}">{{ $producto->stock }}</span>
                </td>
                <td>
                    <span class="status-badge {{ $producto->estado ? 'completed' : 'pending' }}">
                        {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="admin-pagination">
        <span class="pagination-info">
            Mostrando {{ $productos->firstItem() }}-{{ $productos->lastItem() }} de {{ $productos->total() }} productos
        </span>
        <div class="pagination">
            {{-- Botón Anterior --}}
            <button class="pagination-btn prev {{ $productos->onFirstPage() ? 'disabled' : '' }}" 
                onclick="changePage({{ $productos->currentPage() - 1 }})" 
                {{ $productos->onFirstPage() ? 'disabled' : '' }}>
                Anterior
            </button>

            {{-- Números de página --}}
            @for ($i = 1; $i <= $productos->lastPage(); $i++)
                <button class="pagination-btn {{ $i == $productos->currentPage() ? 'active' : '' }}" 
                    onclick="changePage({{ $i }})">
                    {{ $i }}
                </button>
            @endfor

            {{-- Botón Siguiente --}}
            <button class="pagination-btn next {{ !$productos->hasMorePages() ? 'disabled' : '' }}" 
                onclick="changePage({{ $productos->currentPage() + 1 }})" 
                {{ !$productos->hasMorePages() ? 'disabled' : '' }}>
                Siguiente
            </button>
        </div>
    </div>

    <script>
        function changePage(page) {
            // Obtener el iframe padre
            const iframe = window.parent.document.querySelector('iframe');
            
            // Obtener la URL actual del iframe
            const currentUrl = new URL(iframe.src);
            
            // Actualizar el parámetro de página
            currentUrl.searchParams.set('page', page);
            
            // Recargar el iframe con la nueva URL
            iframe.src = currentUrl.toString();
        }
    </script>
</body>
</html>