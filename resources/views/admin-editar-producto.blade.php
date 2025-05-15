<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="card-content">
        <div class="formulario">
            <h2>Productos</h2>
            
            {{-- Formulario de búsqueda --}}
            <div style="margin-bottom: 1rem;">
                <form action="{{ route('admin.buscar-producto') }}" method="GET" class="search-form">
                    @csrf
                    <label class="form-label">Buscar producto:</label>
                    <input type="text" class="search-input" name="nombre_producto" placeholder="Buscar producto por nombre...">
                    <button type="submit" class="btn-primary">Buscar</button>
                </form>
            </div>

            {{-- Tabla de productos --}}
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Número de Producto</th>
                        <th>Nombre del Producto</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id_producto }}</td>
                        <td>{{ $producto->nombre_producto }}</td>
                        <td>{{ $producto->categorias->nombre_categoria ?? 'Sin categoría' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="pagination">
                {{ $productos->links() }}
            </div>

            <h2>Editar producto</h2>
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
            <form action="{{ route('admin.actualizar-producto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="id_producto" value="{{ $productoEncontrado->id_producto ?? '' }}" id="id_usuario">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre del producto:</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" value="{{ $productoEncontrado->nombre_producto ?? '' }}" required>
                </div>
            
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-textarea">{{ $productoEncontrado->descripcion ?? '' }}</textarea>
                </div>
            
                <div class="form-group">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-input" value="{{ $productoEncontrado->stock ?? '' }}" required>
                </div>
            
                <div class="form-group">
                    <label for="estado" class="form-label">Estado:</label>
                    <select id="estado" name="estado" class="form-select">
                        <option value="activo" {{ (isset($productoEncontrado) && $productoEncontrado->estado == 'activo') ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ (isset($productoEncontrado) && $productoEncontrado->estado == 'inactivo') ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" id="precio" step="0.01" name="precio" class="form-input" value="{{ number_format($productoEncontrado->precio ?? 0, 2, '.', '') }}" required>
                </div>
            
                <div class="form-group">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <select id="categoria" name="id_categoria" class="form-select" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}" 
                                {{ (isset($productoEncontrado) && $productoEncontrado->id_categoria == $categoria->id_categoria) ? 'selected' : '' }}>
                                {{ $categoria->nombre_categoria }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="imagen" class="form-label">Imagen del producto:</label>
                    <input type="file" id="imagen" name="imagen" class="form-file" accept="image/*">
                    
                    {{-- Mostrar imagen actual si existe --}}
                    @if(isset($productoEncontrado) && $productoEncontrado->url_imagen)
                        <div class="product-thumbnail-container">
                            <div class="product-thumbnail">
                                <h4>Imagen Actual</h4>
                                <img src="{{ asset('imagenes/' . $productoEncontrado->url_imagen) }}" alt="Imagen del producto">
                            </div>
                        </div>
                    @endif
                </div>
            
                <div class="form-group">
                    <button type="submit" class="btn-success">Guardar producto</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>