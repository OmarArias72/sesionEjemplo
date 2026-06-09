<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Cambiado a styles.css -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>
    <main class="main-content">
        <div class="container">
            <div class="profile-layout">
                <div class="profile-edit">
                    <h1>Registrar nueva categoría</h1>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.categorias-crear') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre de la categoría:</label>
                            <input type="text" id="nombre" name="nombre" class="form-input" required />
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" class="form-textarea" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="id_padre" class="form-label">Categoría padre (opcional):</label>
                            <select id="id_padre" name="id_padre" class="form-select">
                                <option value="">-- Sin categoría padre --</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar categoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>