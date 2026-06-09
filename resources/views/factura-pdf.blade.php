<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Electrónica - {{ $numeroFactura }}</title>
    <style>
        /* ========================================
           RESET Y ESTILOS BASE (Compatibles con PDF)
        ========================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f3f4f6;
            padding: 30px;
            font-size: 13px;
            line-height: 1.5;
            color: #1f2937;
        }
        
        .factura-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
        }
        
        /* ========================================
           TABLAS (Estructura principal)
        ========================================= */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        /* ========================================
           ESPACIADOS (Padding/Margin)
        ========================================= */
        .p-6 { padding: 1.5rem; }
        .p-4 { padding: 1rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        
        /* ========================================
           SISTEMA DE COLUMNAS SEGURO PARA PDF (Floats)
        ========================================= */
        .two-columns {
            width: 100%;
            display: block;
        }
        
        .two-columns .column {
            width: 48%;
            float: left;
        }
        
        .three-columns {
            width: 100%;
            display: block;
        }
        
        .three-columns .column {
            width: 32%;
            float: left;
            margin-right: 1.33%;
        }
        
        .three-columns .column:last-child {
            margin-right: 0;
        }
        
        .clearfix {
            clear: both;
            line-height: 0;
            height: 0;
        }
        
        /* ========================================
           COLORES Y BORDES
        ========================================= */
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-white { background-color: #ffffff; }
        
        .text-white { color: #ffffff !important; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-800 { color: #1f2937; }
        .text-blue-600 { color: #2563eb; }
        
        .border-b { border-bottom: 1px solid #e5e7eb; }
        .border-r { border-right: 1px solid #e5e7eb; }
        .border-t-2 { border-top: 2px solid #d1d5db; }
        
        /* ========================================
           TIPOGRAFÍAS
        ========================================= */
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        
        .font-bold { font-weight: bold; }
        .font-semibold { font-weight: 600; }
        .uppercase { text-transform: uppercase; }
        
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* ========================================
           TABLA DE PRODUCTOS (Estilos Explícitos)
        ========================================= */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .products-table th {
            background-color: #f3f4f6 !important;
            color: #374151;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #d1d5db;
            font-size: 12px;
        }
        
        .products-table td {
            background-color: #ffffff !important;
            color: #4b5563;
            padding: 10px;
            border: 1px solid #e5e7eb;
            font-size: 12px;
        }
        
        /* ========================================
           BADGES
        ========================================= */
        .badge {
            padding: 3px 8px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px;
            display: inline-block;
        }
        .badge-green { background-color: #dcfce7; color: #166534; }
        .badge-blue { background-color: #dbeafe; color: #1e40af; }
        .badge-yellow { background-color: #fef9c3; color: #854d0e; }
        
        /* ========================================
           IMPRESIÓN / CORRECCIÓN
        ========================================= */
        @media print {
            body { padding: 0; background-color: #ffffff; }
        }
    </style>
</head>
<body>
    <div class="factura-container">
        
        <div style="background-color: #2563eb !important; width: 100%; min-height: 90px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #2563eb !important; padding: 20px;">
                <tr>
                    <td width="60%" valign="top" style="vertical-align: top; text-align: left; background-color: #2563eb !important;">
                        <h1 class="text-3xl font-bold" style="color: #ffffff !important; margin-bottom: 5px;">FACTURA ELECTRÓNICA</h1>
                        <p style="color: #e2e8f0 !important; font-size: 13px; margin: 2px 0;">RFC: {{ $configuracion->nombreTitular ?? 'N/A' }}</p>
                        <p style="color: #e2e8f0 !important; font-size: 13px; margin: 2px 0;">Correo: {{ $configuracion->correo ?? 'N/A' }}</p>
                    </td>
                    <td width="40%" valign="top" style="vertical-align: top; text-align: right; background-color: #2563eb !important;">
                        <div class="text-3xl font-bold" style="color: #ffffff !important; margin-bottom: 5px;">TechZone</div>
                        <div style="color: #e2e8f0 !important; font-size: 13px;">Factura #: {{ $numeroFactura }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="p-6 bg-gray-50 border-b">
            <div class="two-columns">
                <div class="column" style="width: 48%; float: left;">
                    <h3 class="font-bold text-gray-700 mb-2 text-lg">DATOS DE LA EMPRESA</h3>
                    <div class="text-sm text-gray-600">
                        <p style="margin-bottom: 3px;"><strong>Nombre:</strong> TechZone</p>
                        <p style="margin-bottom: 3px;"><strong>Titular:</strong> {{ $configuracion->nombreTitular ?? 'No registrado' }}</p>
                        <p style="margin-bottom: 3px;"><strong>Correo:</strong> {{ $configuracion->correo ?? 'No registrado' }}</p>
                        <p style="margin-bottom: 3px;"><strong>Teléfono:</strong> +123 456 7890</p>
                    </div>
                </div>
                <div class="column" style="width: 48%; float: right;">
                    <h3 class="font-bold text-gray-700 mb-2 text-lg">DATOS DEL CLIENTE</h3>
                    <div class="text-sm text-gray-600">
                        <p style="margin-bottom: 3px;"><strong>Nombre:</strong> {{ $pedido->usuario->nombre }} {{ $pedido->usuario->apellido }}</p>
                        <p style="margin-bottom: 3px;"><strong>Email:</strong> {{ $pedido->usuario->email }}</p>
                        <p style="margin-bottom: 3px;"><strong>Teléfono:</strong> {{ $pedido->usuario->telefono ?? 'No registrado' }}</p>
                        @if($pedido->direccion)
                            <p style="margin-bottom: 3px;"><strong>Dirección:</strong> {{ $pedido->direccion->calle }} {{ $pedido->direccion->numeroExterior }}, {{ $pedido->direccion->colonia }}, {{ $pedido->direccion->ciudad }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="p-6 bg-white border-b">
            <div class="three-columns">
                <div class="column">
                    <div class="border-r">
                        <p class="text-xs text-gray-500 uppercase font-bold">NÚMERO DE PEDIDO</p>
                        <p class="text-lg font-semibold text-gray-800">#{{ $pedido->id_pedido }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="border-r">
                        <p class="text-xs text-gray-500 uppercase font-bold">FECHA DE EMISIÓN</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $fechaEmision->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                <div class="column">
                    <p class="text-xs text-gray-500 uppercase font-bold">MÉTODO DE PAGO</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pedido->pago->metodoPago ?? 'PayPal' }}</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="p-6 bg-white">
            <h3 class="font-bold text-gray-800 text-lg" style="margin-bottom: 10px;">DETALLE DE PRODUCTOS</h3>
            
            <table class="products-table">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">CANT.</th>
                        <th width="30%">PRODUCTO</th>
                        <th width="35%">DESCRIPCIÓN</th>
                        <th width="12%" class="text-right">P. UNITARIO</th>
                        <th width="13%" class="text-right">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->detalles as $detalle)
                    <tr>
                        <td class="text-center">{{ $detalle->cantidad }}</td>
                        <td><strong>{{ $detalle->producto->nombre_producto }}</strong></td>
                        <td>{{ Str::limit($detalle->producto->descripcion, 60) }}</td>
                        <td class="text-right">${{ number_format($detalle->precioUnitario, 2) }}</td>
                        <td class="text-right">${{ number_format($detalle->cantidad * $detalle->precioUnitario, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-gray-50 border-b">
            <div class="text-right">
                <table style="width: 300px; margin-left: auto;">
                    <tr>
                        <td class="text-gray-600 text-left" style="padding: 4px 0;">SUBTOTAL:</td>
                        <td class="text-right font-semibold text-gray-800" style="padding: 4px 0;">${{ number_format($subtotal, 2) }}</td>
                    </tr>
                    @if($ivaPorcentaje > 0)
                    <tr>
                        <td class="text-gray-600 text-left" style="padding: 4px 0;">IVA ({{ $ivaPorcentaje }}%):</td>
                        <td class="text-right font-semibold text-gray-800" style="padding: 4px 0;">${{ number_format($iva, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="border-t-2">
                        <td class="text-xl font-bold text-gray-800 text-left" style="padding-top: 10px;">TOTAL:</td>
                        <td class="text-right text-2xl font-bold text-blue-600" style="padding-top: 10px;">${{ number_format($total, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($pedido->envio)
        <div class="p-6 bg-white border-b">
            <h3 class="font-bold text-gray-800 text-lg mb-2">INFORMACIÓN DE ENVÍO</h3>
            
            <div class="two-columns">
                <div class="column" style="width: 48%; float: left;">
                    <p><strong>Estado del envío:</strong> 
                        <span class="badge 
                            @if($pedido->envio->estado == 'Entregado') badge-green
                            @elseif($pedido->envio->estado == 'Enviado') badge-blue
                            @else badge-yellow
                            @endif">
                            {{ $pedido->envio->estado }}
                        </span>
                    </p>
                    @if($pedido->envio->fechaEstimadaEntrega)
                    <p class="mt-2"><strong>Fecha estimada:</strong> 
                        {{ \Carbon\Carbon::parse($pedido->envio->fechaEstimadaEntrega)->format('d/m/Y') }}
                    </p>
                    @endif
                </div>
                <div class="column" style="width: 48%; float: right;">
                    <p><strong>Código de seguimiento:</strong> {{ $pedido->envio->codigoSeguimiento ?? 'No disponible' }}</p>
                    @if($pedido->envio->empresa)
                    <p class="mt-2"><strong>Empresa de envío:</strong> {{ $pedido->envio->empresa->nombreEmpresa }}</p>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        @endif

        <div class="p-4 bg-gray-100 text-center">
            <p class="text-gray-600" style="font-size: 12px;">Esta factura es un comprobante fiscal digital. Para cualquier aclaración, contactar a servicio al cliente.</p>
            <p class="text-gray-600 font-bold" style="font-size: 12px; margin-top: 4px;">© {{ date('Y') }} TechZone - Todos los derechos reservados</p>
            <p class="text-gray-500" style="font-size: 10px; margin-top: 2px;">Factura generada electrónicamente - Fecha: {{ $fechaEmision->format('d/m/Y H:i:s') }}</p>
        </div>
        
    </div>
</body>
</html>