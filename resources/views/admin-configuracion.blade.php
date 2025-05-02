<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TiendaOnline - Configuración</title>
  <link rel="stylesheet" href="styles.css" />
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
                <li>
                    <a href="{{route('admin.pagos')}}">
                        <i class="fas fa-credit-card"></i>
                        <span>Pagos</span>
                    </a>
                </li>
                <li class="active">
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
      <header class="admin-header">
        <h1>Configuración</h1>
        <div class="admin-header-actions">
          <div class="admin-user">
            <div class="admin-avatar">A</div>
            <span>Admin</span>
          </div>
        </div>
      </header>

      <main class="admin-content">
        <div class="settings-layout">
          <!-- Settings Sidebar -->
          <div class="settings-sidebar">
            <ul class="settings-nav">
              <li class="active">
                <a href="#general"><i class="fas fa-store"></i> General</a>
              </li>
              <li>
                <a href="#payment"><i class="fas fa-credit-card"></i> Métodos de Pago</a>
              </li>
              <li>
                <a href="#shipping"><i class="fas fa-truck"></i> Envíos</a>
              </li>
              <li>
                <a href="#tax"><i class="fas fa-percentage"></i> Impuestos</a>
              </li>
            </ul>
          </div>

          <!-- Settings Content -->
          <div class="settings-content">

            <!-- General -->
            <div class="settings-section" id="general">
              <h2>Configuración General</h2>
              <!-- Contenido general omitido por brevedad -->
            </div>

            <!-- Métodos de Pago -->
            <div class="settings-section" id="payment">
              <h2>Configuración de PayPal</h2>
              <form id="paypal-config-form" class="settings-form" 
                    action="{{ isset($paypalConfig) ? route('admin.configuracion.update', $paypalConfig->id_configuracion) : route('admin.configuracion.store') }}" 
                    method="POST">
                  @csrf
                  @if(isset($paypalConfig))
                      @method('PUT')
                  @endif
                  
                  <div class="form-group">
                      <label for="paypal-email">Correo de Cuenta PayPal</label>
                      <input type="email" id="paypal-email" name="paypal-email" 
                            value="{{ $paypalConfig->correo ?? old('paypal-email') }}" 
                            placeholder="ejemplo@negocio.com" required />
                  </div>
                  <div class="form-group">
                      <label for="paypal-name">Nombre del Titular</label>
                      <input type="text" id="paypal-name" name="paypal-name" 
                            value="{{ $paypalConfig->nombreTitular ?? old('paypal-name') }}" 
                            placeholder="Nombre del titular de la cuenta" />
                  </div>
                  {{-- <div class="form-group">
                      <label for="paypal-mode">Modo de Integración</label>
                      <select id="paypal-mode" name="paypal-mode">
                          <option value="live" {{ (isset($paypalConfig) && $paypalConfig->modo == 'live') ? 'selected' : '' }}>Producción</option>
                          <option value="sandbox" {{ (isset($paypalConfig) && $paypalConfig->modo == 'sandbox') ? 'selected' : '' }}>Sandbox (Pruebas)</option>
                      </select>
                  </div> --}}
                  <div class="form-actions">
                      <button type="submit" class="btn btn-primary">
                          {{ isset($paypalConfig) ? 'Actualizar Configuración' : 'Guardar Configuración' }}
                      </button>
                  </div>
              </form>
            </div>
            <!-- Envíos -->
            <div class="settings-section" id="shipping">
              <h2>Registrar Nueva Empresa de Envío</h2>
              <form id="envio-form" class="settings-form">
                <div class="form-group">
                  <label for="nueva-empresa">Nombre de la Empresa</label>
                  <input type="text" id="nueva-empresa" name="nueva-empresa" placeholder="Ej. DHL, FedEx, Estafeta" required />
                </div>
                <div class="form-group">
                  <label for="contacto-empresa">Correo de Contacto</label>
                  <input type="email" id="contacto-empresa" name="contacto-empresa" placeholder="contacto@empresa.com" required />
                </div>
                <div class="form-group">
                  <label for="telefono-empresa">Teléfono</label>
                  <input type="tel" id="telefono-empresa" name="telefono-empresa" placeholder="+52 123 456 7890" />
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Registrar Empresa</button>
                  <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
              </form>

              <h3>Empresas Registradas</h3>
              <table class="envios-table" id="tabla-empresas-envio">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Las filas se insertan dinámicamente aquí -->
                </tbody>
              </table>
            </div>

            <!-- Impuestos -->
            <div class="settings-section" id="tax">
              <h2>Configuración de IVA</h2>
              <form id="iva-form" class="settings-form" 
                    action="{{ isset($ivaConfig) ? route('admin.configuracion.iva.update', $ivaConfig->id_configuracion) : route('admin.configuracion.iva.store') }}" 
                    method="POST">
                  @csrf
                  @if(isset($ivaConfig))
                      @method('PUT')
                  @endif
                  
                  <div class="form-group">
                      <label for="iva-porcentaje">Porcentaje de IVA</label>
                      <input type="number" id="iva-porcentaje" name="iva-porcentaje" 
                            value="{{ $ivaConfig->iva ?? old('iva-porcentaje') }}" 
                            min="0" max="100" step="0.01" 
                            placeholder="Ej. 16" required />
                  </div>
                  <div class="form-actions">
                      <button type="submit" class="btn btn-primary">
                          {{ isset($ivaConfig) ? 'Actualizar IVA' : 'Guardar IVA' }}
                      </button>
                  </div>
              </form>
            </div>

          </div>
        </div>
      </main>
    </div>
  </div>
  <script></script>
</body>
</html>
