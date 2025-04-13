<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaOnline - Iniciar Sesión</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="/" class="logo">TiendaOnline</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <h1>Iniciar Sesión</h1>
                        <p>Accede a tu cuenta para gestionar tus pedidos</p>
                    </div>

                    <!-- Mostrar mensaje de sesión -->
                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Mostrar errores -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario de Login -->
                    <form class="auth-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-icon relative">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                                <i class="fas fa-eye toggle-password absolute right-2 top-3 cursor-pointer"></i>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-4">Iniciar Sesión</button>
                    </form>
                    
                    <div class="auth-footer mt-4">
                        @if (Route::has('password.request'))
                            <p><a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></p>
                        @endif

                        <p>¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-10">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>TiendaOnline</h3>
                    <p>Tu tienda de confianza para compras en línea.</p>
                </div>
                <div class="footer-column">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/productos">Productos</a></li>
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Categorías</h4>
                    <ul>
                        <li><a href="/productos?categoria=electronica">Electrónica</a></li>
                        <li><a href="/productos?categoria=ropa">Ropa</a></li>
                        <li><a href="/productos?categoria=hogar">Hogar</a></li>
                        <li><a href="/productos?categoria=deportes">Deportes</a></li>
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
            <div class="footer-bottom text-center">
                <p>&copy; 2025 TiendaOnline. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- JS para toggle de contraseña -->
    <script>
        document.querySelector('.toggle-password')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
