<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechZone - Gestión de Envíos</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <style>
        /* Estilos para las notificaciones toast */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideInRight 0.3s ease-out;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .toast-success {
            background-color: #10b981;
            color: white;
            border-left: 4px solid #059669;
        }
        
        .toast-error {
            background-color: #ef4444;
            color: white;
            border-left: 4px solid #dc2626;
        }
        
        .toast-warning {
            background-color: #f59e0b;
            color: white;
            border-left: 4px solid #d97706;
        }
        
        .toast-info {
            background-color: #3b82f6;
            color: white;
            border-left: 4px solid #2563eb;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            margin-left: 8px;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        
        .toast-close:hover {
            opacity: 1;
        }
        
        .toast-icon {
            font-size: 20px;
        }
        
        .toast-message {
            flex: 1;
        }
        
        /* Modal de confirmación */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .modal-container {
            background: white;
            border-radius: 12px;
            padding: 24px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            animation: scaleIn 0.2s ease-out;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .modal-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 16px;
            color: #1f2937;
        }
        
        .modal-body {
            margin-bottom: 24px;
            color: #4b5563;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        .modal-btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        
        .modal-btn-cancel {
            background-color: #e5e7eb;
            color: #374151;
        }
        
        .modal-btn-cancel:hover {
            background-color: #d1d5db;
        }
        
        .modal-btn-confirm {
            background-color: #3b82f6;
            color: white;
        }
        
        .modal-btn-confirm:hover {
            background-color: #2563eb;
        }
        
        /* Spinner de carga */
        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Destacar pedidos clickeables */
        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .clickable-row:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="admin-body">
    <div class="envios-container">
        <!-- Mostrar mensajes flash de sesión -->
        @if(session('success'))
            <div class="toast-notification toast-success" id="flash-toast">
                <i class="fas fa-check-circle toast-icon"></i>
                <span class="toast-message">{{ session('success') }}</span>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="toast-notification toast-error" id="flash-toast">
                <i class="fas fa-exclamation-circle toast-icon"></i>
                <span class="toast-message">{{ session('error') }}</span>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
            </div>
        @endif

        <!-- Sección: Tabla de pedidos -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-shopping-cart"></i> Pedidos pendientes de envío</h2>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>N° Pedido</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>N° Productos</th>
                                <th>Total</th>
                                <th>Estado Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            <tr class="clickable-row" data-pedido-id="{{ $pedido->id_pedido }}" data-pedido-numero="{{ $pedido->id_pedido }}">
                                <td>#{{ $pedido->id_pedido }}</td>
                                <td>{{ $pedido->usuario->nombre }} {{ $pedido->usuario->apellido }}</td>
                                <td>
                                    @if ($pedido->created_at)
                                        {{ $pedido->created_at->format('Y-m-d') }}
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>{{ $pedido->detalles ? $pedido->detalles->sum('cantidad') : 0 }}</td>
                                <td>${{ number_format($pedido->pago->montoPagado ?? 0, 2) }}</td>
                                <td>
                                    @if($pedido->pago)
                                        <span class="status-badge {{ $pedido->pago->estado == 'completado' ? 'paid' : 'pending' }}">
                                            {{ ucfirst($pedido->pago->estado) }}
                                        </span>
                                    @else
                                        <span class="status-badge pending">Sin pago</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Paginación -->
                <div class="pagination-container">
                    {{ $pedidos->links() }}
                </div>
            </div>
        </div>

        <!-- Sección: Asignación de envíos -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-truck"></i> Asignar envío a pedido</h2>
            </div>
            <div class="card-content">
                <form id="assignment-form" class="envio-form" action="{{ route('admin.store.envio') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="order-id-assign" class="form-label">Número de Pedido:</label>
                            <input type="number" id="order-id-assign" name="order-id-assign" class="form-input" placeholder="Ej: 123" required>
                            <small class="form-text text-muted">Puedes hacer clic en cualquier fila de la tabla para autocompletar</small>
                        </div>
                        <div class="form-group">
                            <label for="external-company" class="form-label">Empresa de Envío:</label>
                            <select id="external-company" name="external-company" class="form-select" required>
                                <option value="">Seleccione una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombreEmpresa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="submit-assignment" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Asignar envío
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sección: Registrar nueva empresa de envío -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-building"></i> Registrar nueva empresa de envío</h2>
            </div>
            <div class="card-content">
                <form id="company-form" class="company-form" action="{{ route('admin.empresa.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nueva-empresa" class="form-label">Nombre de la empresa *</label>
                            <input type="text" id="nueva-empresa" name="nueva-empresa" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="nuevo-contacto" class="form-label">Nombre de contacto *</label>
                            <input type="text" id="nuevo-contacto" name="nuevo-contacto" class="form-input" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono-empresa" class="form-label">Teléfono de contacto *</label>
                            <input type="tel" id="telefono-empresa" name="telefono-empresa" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="contacto-empresa" class="form-label">Correo electrónico *</label>
                            <input type="email" id="contacto-empresa" name="contacto-empresa" class="form-input" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Guardar empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar notificaciones toast
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            
            let icon = '';
            switch(type) {
                case 'success':
                    icon = '<i class="fas fa-check-circle toast-icon"></i>';
                    break;
                case 'error':
                    icon = '<i class="fas fa-exclamation-circle toast-icon"></i>';
                    break;
                case 'warning':
                    icon = '<i class="fas fa-exclamation-triangle toast-icon"></i>';
                    break;
                case 'info':
                    icon = '<i class="fas fa-info-circle toast-icon"></i>';
                    break;
            }
            
            toast.innerHTML = `
                ${icon}
                <span class="toast-message">${message}</span>
                <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
            `;
            
            document.body.appendChild(toast);
            
            // Auto cerrar después de 5 segundos
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.animation = 'slideOutRight 0.3s ease-out';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }
        
        function closeToast(button) {
            const toast = button.parentElement;
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }
        
        // Función para mostrar modal de confirmación
        function showConfirmModal(options) {
            return new Promise((resolve) => {
                const overlay = document.createElement('div');
                overlay.className = 'modal-overlay';
                
                const modal = document.createElement('div');
                modal.className = 'modal-container';
                
                modal.innerHTML = `
                    <div class="modal-header">${options.title || 'Confirmar acción'}</div>
                    <div class="modal-body">${options.message || '¿Estás seguro de realizar esta acción?'}</div>
                    <div class="modal-footer">
                        <button class="modal-btn modal-btn-cancel">Cancelar</button>
                        <button class="modal-btn modal-btn-confirm">${options.confirmText || 'Confirmar'}</button>
                    </div>
                `;
                
                overlay.appendChild(modal);
                document.body.appendChild(overlay);
                
                const confirmBtn = modal.querySelector('.modal-btn-confirm');
                const cancelBtn = modal.querySelector('.modal-btn-cancel');
                
                confirmBtn.onclick = () => {
                    overlay.remove();
                    resolve(true);
                };
                
                cancelBtn.onclick = () => {
                    overlay.remove();
                    resolve(false);
                };
                
                // Cerrar al hacer clic fuera
                overlay.onclick = (e) => {
                    if (e.target === overlay) {
                        overlay.remove();
                        resolve(false);
                    }
                };
            });
        }
        
        // Manejar envío del formulario de asignación
        document.getElementById('assignment-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submit-assignment');
            const orderId = document.getElementById('order-id-assign').value;
            const companyId = document.getElementById('external-company').value;
            
            // Validaciones
            if (!orderId) {
                showToast('Por favor, ingresa el número de pedido', 'warning');
                return;
            }
            
            if (!companyId) {
                showToast('Por favor, selecciona una empresa de envío', 'warning');
                return;
            }
            
            // Confirmación
            const confirmed = await showConfirmModal({
                title: 'Confirmar asignación',
                message: `¿Deseas asignar el pedido #${orderId} a la empresa seleccionada?`,
                confirmText: 'Sí, asignar'
            });
            
            if (!confirmed) return;
            
            // Mostrar estado de carga
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner"></span> Procesando...';
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message || 'Envío asignado exitosamente', 'success');
                    form.reset();
                    
                    // Recargar la tabla de pedidos después de 1 segundo
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(result.message || 'Error al asignar el envío', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Ocurrió un error al procesar la solicitud', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.classList.remove('btn-loading');
                submitBtn.disabled = false;
            }
        });
        
        // Autocompletar número de pedido al hacer clic en la tabla
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                const pedidoId = this.getAttribute('data-pedido-id');
                const orderInput = document.getElementById('order-id-assign');
                orderInput.value = pedidoId;
                
                // Resaltar el input
                orderInput.style.backgroundColor = '#e8f0fe';
                setTimeout(() => {
                    orderInput.style.backgroundColor = '';
                }, 500);
                
                showToast(`Pedido #${pedidoId} seleccionado`, 'info');
                
                // Opcional: Hacer scroll al formulario
                document.querySelector('.card:has(#assignment-form)').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
        
        // Validar número de pedido
        document.getElementById('order-id-assign').addEventListener('input', function(e) {
            let value = parseInt(e.target.value);
            if (value < 1) {
                e.target.value = '';
            }
        });
        
        // Manejar envío del formulario de empresa (similar para mostrar feedback)
        document.getElementById('company-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const empresaNombre = document.getElementById('nueva-empresa').value;
            
            if (!empresaNombre) {
                showToast('Por favor, ingresa el nombre de la empresa', 'warning');
                return;
            }
            
            const confirmed = await showConfirmModal({
                title: 'Confirmar registro',
                message: `¿Deseas registrar la empresa "${empresaNombre}"?`,
                confirmText: 'Sí, registrar'
            });
            
            if (!confirmed) return;
            
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner"></span> Registrando...';
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message || 'Empresa registrada exitosamente', 'success');
                    form.reset();
                    
                    // Recargar para mostrar la nueva empresa en el select
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(result.message || 'Error al registrar la empresa', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Ocurrió un error al procesar la solicitud', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.classList.remove('btn-loading');
                submitBtn.disabled = false;
            }
        });
        
        // Auto cerrar toast flash después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const flashToast = document.getElementById('flash-toast');
            if (flashToast) {
                setTimeout(() => {
                    if (flashToast.parentElement) {
                        flashToast.style.animation = 'slideOutRight 0.3s ease-out';
                        setTimeout(() => flashToast.remove(), 300);
                    }
                }, 5000);
            }
        });
    </script>
</body>
</html>