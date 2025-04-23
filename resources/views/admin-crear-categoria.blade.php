<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="profile-layout">
                <!-- Formulario de creación de categoría -->
                <div class="profile-edit">
                    <h1>Registrar nueva categoría</h1>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.categorias-crear') }}" method="POST">
                        @csrf
                        <label for="nombre">Nombre de la categoría:</label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            required
                        />

                        <label for="descripcion">Descripción:</label>
                        <textarea
                            id="descripcion"
                            name="descripcion"
                            required
                        ></textarea>

                        <label for="id_padre">Categoría padre (opcional):</label>
                        <select id="id_padre" name="id_padre">
                            <option value="">-- Sin categoría padre --</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary">Guardar categoría</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>

    </script>
</body>
</html>