<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Administración de Pagos</title>
    <link rel="stylesheet" href="styles.css">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-logo">TiendaOnline</h1>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{route('admin.dashboard-admin')}}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.productos')}}">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.pedidos')}}">
                            <i class="fas fa-box"></i>
                            <span>Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.envios')}}">
                            <i class="fas fa-truck"></i>
                            <span>Envíos</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{route('admin.pagos')}}">
                            <i class="fas fa-credit-card"></i>
                            <span>Pagos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.configuracion')}}">
                            <i class="fas fa-cog"></i>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            {{-- <div class="sidebar-footer">
                <a href="#" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div> --}}
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <h1>Gestión de Pagos</h1>
                
                <div class="admin-header-actions">
                    <div class="admin-search">
                        <input type="text" placeholder="Buscar pagos...">
                        <i class="fas fa-search"></i>
                    </div>
                    
                    <div class="admin-user">
                        <div class="admin-avatar">A</div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <!-- Payments Content -->
            <main class="admin-content">
                <div class="admin-toolbar">
                    <div class="admin-filters">
                        <form method="GET" action="{{ route('admin.pagos-filtrar') }}">
                            <select class="filter-select" name="estado">
                                <option value="todos" {{ request('estado') == 'todos' || !request('estado') ? 'selected' : '' }}>Todos los estados</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                <option value="COMPLETED" {{ request('estado') == 'Completado' ? 'selected' : '' }}>Completado</option>
                            </select>
                            
                            <div class="date-filter">
                                <label>Desde:</label>
                                <input type="date" class="date-input" name="desde" value="{{ request('desde') }}">
                            </div>
                            
                            <div class="date-filter">
                                <label>Hasta:</label>
                                <input type="date" class="date-input" name="hasta" value="{{ request('hasta') }}">
                            </div>
                            
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>

                            @if(request('estado') || request('desde') || request('hasta'))
                            <a href="{{ route('admin.pagos') }}" class="btn btn-tertiary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                            @endif
                        </form>
                    </div>
                    
                    {{-- <button class="btn btn-primary">
                        <i class="fas fa-file-export"></i> Exportar
                    </button> --}}
                </div>
                
                <div class="admin-card">
                    <div class="card-content">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID Transacción</th>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Método</th>
                                    <th>Importe</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagos as $pago)
                                <tr>
                                    <td>{{ $pago['id_transaccion'] }}</td>
                                    <td class="order-id">{{ $pago['numero_pedido'] }}</td>
                                    <td>{{ $pago['nombre_cliente'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pago['fecha_pago'])->format('d M Y') }}</td>
                                    <td>
                                        <div class="payment-method">
                                            @if(str_contains(strtolower($pago['metodo_pago']), 'paypal'))
                                                <i class="fab fa-paypal"></i> PayPal
                                            @elseif(str_contains(strtolower($pago['metodo_pago']), 'visa'))
                                                <i class="fab fa-cc-visa"></i> Visa
                                            @elseif(str_contains(strtolower($pago['metodo_pago']), 'mastercard'))
                                                <i class="fab fa-cc-mastercard"></i> MasterCard
                                            @elseif(str_contains(strtolower($pago['metodo_pago']), 'transferencia'))
                                                <i class="fas fa-university"></i> Transferencia Bancaria
                                            @else
                                                {{ $pago['metodo_pago'] }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>${{ number_format($pago['monto_pagado'], 2) }}</td>
                                    <td>
                                        <span class="payment-status 
                                            @if($pago['estado'] == 'Completado') paid 
                                            @elseif($pago['estado'] == 'Pendiente') pending 
                                            @elseif($pago['estado'] == 'Fallido') failed 
                                            @elseif($pago['estado'] == 'Reembolsado') refunded 
                                            @endif">
                                            {{ $pago['estado'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                                            <button class="btn-icon receipt"><i class="fas fa-file-invoice"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    </div>
                    
                    <!-- Paginación -->
                    <div class="admin-pagination">
                        <span class="pagination-info">
                            Mostrando {{ $pagos->firstItem() }}-{{ $pagos->lastItem() }} de {{ $pagos->total() }} pagos
                        </span>
                        <div class="pagination">
                            @if($pagos->onFirstPage())
                                <button class="pagination-btn prev" disabled>Anterior</button>
                            @else
                                <a href="{{ $pagos->previousPageUrl() }}" class="pagination-btn prev">Anterior</a>
                            @endif

                            @foreach(range(1, $pagos->lastPage()) as $page)
                                @if($page == $pagos->currentPage())
                                    <button class="pagination-btn active">{{ $page }}</button>
                                @else
                                    <a href="{{ $pagos->url($page) }}" class="pagination-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($pagos->hasMorePages())
                                <a href="{{ $pagos->nextPageUrl() }}" class="pagination-btn next">Siguiente</a>
                            @else
                                <button class="pagination-btn next" disabled>Siguiente</button>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script></script>
</body>
</html>