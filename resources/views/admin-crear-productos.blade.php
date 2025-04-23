<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    @vite('resources/css/app.css')
    <table style="display: none;">
        <tbody id="fila-template">
            <tr>
                <input type="hidden" name="id_producto[]" value="">
                <td><input type="text" class="form-input" name="nombre[]" value="" required></td>
                <td><textarea class="form-textarea" name="descripcion[]" required></textarea></td>
                <td><input type="number" class="form-input" name="stock[]" value="" min="0" required></td>
                <td>
                    <select class="form-select" name="estado[]" required>
                        <option value="activo" selected>Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </td>
                <td><input type="number" class="form-input" name="precio[]" step="0.01" value="" min="0" required></td>
                <td>
                    <select class="form-select" name="id_categoria[]" required>
                        <option value="">Selecciona</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="file" class="form-file" name="imagen[]" accept="image/*">
                </td>
                <td>
                    <button type="button" class="btn-icon delete" onclick="eliminarFila(this)"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</head>
<body>
    <div class="card-content">
        <div class="formulario">
            <h2>Registrar productos desde tabla</h2>

            {{-- Mostrar errores --}}
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

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success" style="color: green;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div style="margin-bottom: 1rem;">
                <form action="{{route('admin.productos.buscar')}}" method="GET" class="search-form">
                    <input type="text" class="search-input" name="valor" value="{{ request('valor') }}" placeholder="Buscar productos...">
                    <button type="submit" class="btn-primary">Buscar</button>
                </form>
            </div>
            
            {{-- <a href="{{ route('create-product') }}" class="btn-link">Ver productos</a> --}}
            
            <form action="{{ route('admin.productos.registrar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="admin-table" id="tabla-productos">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $index => $producto)
                        <tr>
                            <input type="hidden" name="id_producto[]" value="{{ $producto->id_producto }}">
                            <td><input type="text" class="form-input" name="nombre[]" value="{{ $producto->nombre_producto }}" disabled required></td>
                            <td><textarea class="form-textarea" name="descripcion[]" disabled required>{{ $producto->descripcion }}</textarea></td>
                            <td><input type="number" class="form-input" name="stock[]" value="{{ $producto->stock }}" min="0" disabled required></td>
                            <td>
                                <select class="form-select" name="estado[]" disabled required>
                                    <option value="activo" {{ $producto->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ $producto->estado === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </td>
                            <td><input type="number" class="form-input" name="precio[]" step="0.01" value="{{ $producto->precio }}" min="0" disabled required></td>
                            <td>
                                <select class="form-select" name="id_categoria[]" disabled required>
                                    <option value="">Selecciona</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}"
                                            {{ $producto->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                                            {{ $categoria->nombre_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @if ($producto->url_imagen)
                                    <div class="product-thumbnail">
                                        <img src="{{ asset('imagenes/' . $producto->url_imagen) }}" alt="imagen">
                                    </div>
                                @endif
                                <input type="file" class="form-file" name="imagen[]" accept="image/*" disabled>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-icon edit" onclick="habilitarEdicion(this)"><i class="fas fa-edit"></i></button>
                                    <button type="submit" class="btn-icon save" name="action" value="guardar" data-index="{{$index}}"><i class="fas fa-save"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="pagination">
                    {{ $productos->links() }}
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <button type="button" class="btn-primary" onclick="agregarFila()"><i class="fas fa-plus"></i> Agregar Producto</button>
                </div>

                <button type="submit" class="btn-success"><i class="fas fa-check"></i> Confirmar Registro</button>
            </form>
        </div>
    </div>
    <script>
        function agregarFila() {
            const template = document.querySelector('#fila-template tr');
            const nuevaFila = template.cloneNode(true);
            const tbody = document.querySelector('#tabla-productos tbody');
            const indice = tbody.rows.length;

            nuevaFila.querySelectorAll('input, textarea, select').forEach(el => {
                el.disabled = false;
                el.value = ''; // limpiar el valor
                el.name = el.name.replace('[]', `[${indice}]`); // actualizar el nombre del campo
            });

            const columnaEliminar = nuevaFila.querySelector('td:last-child');
            columnaEliminar.innerHTML = `
                <button type="button" onclick="eliminarFila(this)">❌ Eliminar</button>
                <button type="submit" name="action" value="crear" data-index="${indice}">✅ Confirmar Registro</button>
            `;

            tbody.appendChild(nuevaFila);
        }
        function eliminarFila(boton) {
            const fila = boton.closest('tr');
            const tbody = fila.parentElement;
            if (tbody.rows.length > 1) {
                fila.remove();
            } else {
                alert("Debe haber al menos una fila.");
            }
        }
        function habilitarEdicion(boton) {
            const fila = boton.closest('tr');
            
            // Habilitar todos los campos de la fila
            fila.querySelectorAll('input, textarea, select').forEach(el => el.disabled = false);
            
            // Habilitar también el botón de guardar (si estuviera deshabilitado por alguna razón)
            const botonGuardar = fila.querySelector('button[type="submit"]');
            if (botonGuardar) {
                botonGuardar.disabled = false;
            }
                }

        document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            form.querySelectorAll('input:disabled, textarea:disabled, select:disabled').forEach(el => {
                el.disabled = false;
            });
        });
        });
        // Modifica el manejo del evento submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Solo procesar si el envío viene de un botón de acción
                const submitBtn = e.submitter || document.activeElement;
                
                if (submitBtn && submitBtn.name === 'action') {
                    const action = submitBtn.value;
                    const index = submitBtn.getAttribute('data-index');
                    
                    // Validar que el índice sea correcto
                    if (index === null || index === undefined) {
                        e.preventDefault();
                        alert('Error: Índice no definido');
                        return;
                    }
                    
                    // Crear inputs hidden para los parámetros
                    const inputAction = document.createElement('input');
                    inputAction.type = 'hidden';
                    inputAction.name = 'action';
                    inputAction.value = action;
                    
                    const inputIndex = document.createElement('input');
                    inputIndex.type = 'hidden';
                    inputIndex.name = 'index';
                    inputIndex.value = index;
                    
                    this.appendChild(inputAction);
                    this.appendChild(inputIndex);
                    
                    // Habilitar todos los campos deshabilitados antes de enviar
                    this.querySelectorAll('input:disabled, textarea:disabled, select:disabled').forEach(el => {
                        el.disabled = false;
                    });
                }
            });
        });

    </script>
    </script>
</body>