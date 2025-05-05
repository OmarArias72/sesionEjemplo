<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Envíos</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    @vite('resources/css/app.css')
    <style>
        .clickable-row { cursor: pointer; }
        .clickable-row:hover { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="card-content">
        <div class="formulario">
            <h2>Envíos</h2>
            
            {{-- Tabla de envíos --}}
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
                    <tr class="clickable-row" data-envio-id="{{ $envio->id_envio }}">
                        <td>{{ $envio->id_envio }}</td>
                        <td>{{ $envio->id_pedido }}</td>
                        <td>{{ $envio->estado }}</td>
                        <td>{{ $envio->codigoSeguimiento }}</td>
                        <td>{{ $envio->fechaEnvio ? $envio->fechaEnvio->format('d/m/Y') : '-' }}</td>
                        <td>{{ $envio->fechaEstimadaEntrega ? $envio->fechaEstimadaEntrega->format('d/m/Y') : '-' }}</td>
                        <td>{{ $envio->fechaEntrega ? $envio->fechaEntrega->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="pagination">
                {{ $envios->links() }}
            </div>

            <h2>Actualizar envío</h2>
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
            
            <form action="{{ route('admin.pedido-envio.actualizar') }}" method="POST">

                @csrf
                @method("PUT")
                <input type="hidden" name="numero_envio" id="numero_envio">
                
                <div class="form-group">
                    <label for="estado" class="form-label">Estado:</label>
                    <select id="estado" name="estado" class="form-select" required>
                        <option value="">Seleccione un estado</option>
                        <option value="{{ App\Models\Envio::ESTADO_PENDIENTE }}">Pendiente</option>
                        <option value="{{ App\Models\Envio::ESTADO_ENVIADO }}">Enviado</option>
                        <option value="{{ App\Models\Envio::ESTADO_ENTREGADO }}">Entregado</option>
                        <option value="{{ App\Models\Envio::ESTADO_CANCELADO }}">Cancelado</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="codigoSeguimiento" class="form-label">Código de Seguimiento:</label>
                    <input type="text" id="codigoSeguimiento" name="codigoSeguimiento" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="fechaEnvio" class="form-label">Fecha de Envío:</label>
                    <input type="date" id="fechaEnvio" name="fechaEnvio" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="fechaEstimadaEntrega" class="form-label">Fecha Estimada de Entrega:</label>
                    <input type="date" id="fechaEstimadaEntrega" name="fechaEstimadaEntrega" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="fechaEntrega" class="form-label">Fecha de Entrega:</label>
                    <input type="date" id="fechaEntrega" name="fechaEntrega" class="form-input">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-success">Actualizar envío</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionar fila de la tabla
            const rows = document.querySelectorAll('.clickable-row');
            
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    // Establecer el valor del campo oculto
                    const envioId = this.getAttribute('data-envio-id');
                    document.getElementById('numero_envio').value = envioId;
                    
                    // Resaltar fila seleccionada
                    rows.forEach(r => r.style.backgroundColor = '');
                    this.style.backgroundColor = '#e0f7fa';
                    
                    // Opcional: Cargar datos del envío seleccionado en el formulario
                    // Esto requeriría una llamada AJAX para obtener los datos completos
                });
            });
        });
    </script>
</body>
</html>