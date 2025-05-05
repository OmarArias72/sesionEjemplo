<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }
        .status-pendiente { background-color: #fff3cd; color: #856404; }
        .status-enviado { background-color: #cce5ff; color: #004085; }
        .status-entregado { background-color: #d4edda; color: #155724; }
        .status-cancelado { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="card-content">
        <h2>Gestión de Envíos</h2>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>N° Envío</th>
                    <th>N° Pedido</th>
                    <th>Estado</th>
                    <th>Código Seguimiento</th>
                    <th>Fecha Envío</th>
                    <th>Fecha Estimada</th>
                    <th>Fecha Entrega</th>
                </tr>
            </thead>
            <tbody>
                @foreach($envios as $envio)
                <tr>
                    <td>#{{ $envio->id_envio }}</td>
                    <td>#{{ $envio->id_pedido }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($envio->estado) }}">
                            {{ $envio->estado }}
                        </span>
                    </td>
                    <td>{{ $envio->codigoSeguimiento ?? 'N/A' }}</td>
                    <td>{{ $envio->fechaEnvio ? \Carbon\Carbon::parse($envio->fechaEnvio)->format('d/m/Y') : 'Pendiente' }}</td>
                    <td>{{ $envio->fechaEstimadaEntrega ? \Carbon\Carbon::parse($envio->fechaEstimadaEntrega)->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $envio->fechaEntrega ? \Carbon\Carbon::parse($envio->fechaEntrega)->format('d/m/Y') : 'Pendiente' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="admin-pagination">
            <span class="pagination-info">
                Mostrando {{ $envios->firstItem() }}-{{ $envios->lastItem() }} de {{ $envios->total() }} envíos
            </span>
            <div class="pagination">
                {{-- Botón Anterior --}}
                <button class="pagination-btn prev {{ $envios->onFirstPage() ? 'disabled' : '' }}" 
                    onclick="changePage({{ $envios->currentPage() - 1 }})" 
                    {{ $envios->onFirstPage() ? 'disabled' : '' }}>
                    <i class="fas fa-chevron-left"></i> Anterior
                </button>

                {{-- Números de página --}}
                @for ($i = 1; $i <= $envios->lastPage(); $i++)
                    <button class="pagination-btn {{ $i == $envios->currentPage() ? 'active' : '' }}" 
                        onclick="changePage({{ $i }})">
                        {{ $i }}
                    </button>
                @endfor

                {{-- Botón Siguiente --}}
                <button class="pagination-btn next {{ !$envios->hasMorePages() ? 'disabled' : '' }}" 
                    onclick="changePage({{ $envios->currentPage() + 1 }})" 
                    {{ !$envios->hasMorePages() ? 'disabled' : '' }}>
                    Siguiente <i class="fas fa-chevron-right"></i>
                </button>
            </div>
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