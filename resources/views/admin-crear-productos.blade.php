<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="card-content">
        <div class="formulario">
            <h2>Registrar nuevo producto</h2>
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
            
            <form action="{{ route('admin.productos.registrar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre del producto:</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-textarea"></textarea>
                </div>

                <div class="form-group">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="estado" class="form-label">Estado:</label>
                    <select id="estado" name="estado" class="form-select">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" id="precio" step="0.01" name="precio" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <select id="categoria" name="id_categoria" class="form-select" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="imagen" class="form-label">Imagen del producto:</label>
                    <input type="file" id="imagen" name="imagen" class="form-file" accept="image/*">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-success"><i class="fas fa-check"></i> Guardar producto</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>