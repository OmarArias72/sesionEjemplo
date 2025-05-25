<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Configuracion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function getViewCrearProductos(){
        $categorias = Categoria::all();
        return view('admin-crear-productos', compact('categorias'));
    
    }

    public function createEditView(){
        $productos = Producto::with('categorias')
                    ->orderBy('nombre_producto', 'asc')
                    ->paginate(5, ['*'], 'productos_page');
        
        $categorias = Categoria::all(); // Asegúrate de importar el modelo Categoria
        
        return view('admin-editar-producto', compact('productos', 'categorias'));
    }

    public function buscarProductoEditForm(Request $request){
        $nombre=$request->input("nombre_producto");
        $productos = Producto::with('categorias')
        ->orderBy('nombre_producto', 'asc')
        ->paginate(5, ['*'], 'productos_page');

        $productoEncontrado=Producto::with("categorias")
            ->where("nombre_producto","like","%{$nombre}%")->first();
        if(!$productoEncontrado){
            return back()->withErrors('error', 'Producto no encontrado');
        }
        
        //Log::info("Producto encontrado",["Nombre"=>$productoEncontrado->nombre_producto]);
        // Obtener todas las categorías para llenar el select
        $categorias = Categoria::all();
        return view("admin-editar-producto",compact("productoEncontrado","productos","categorias"));
    }

    // public function searchProducto(Request $request){
    //     $valorBuscar = $request->input("valor");
        
    //     $productos = Producto::query()
    //         ->when($valorBuscar, function($query, $valorBuscar) {
    //             return $query->where("nombre_producto", "like", "%{$valorBuscar}%");
    //         })
    //         ->orderBy("created_at", "desc")
    //         ->paginate(10)
    //         ->appends(['search' => $valorBuscar]);
        
    //     // Obtener las categorías necesarias para el formulario
    //     $categorias = Categoria::all();
        
    //     return view("admin-crear-productos", compact("productos", "valorBuscar", "categorias"));
    // }

    public function store(Request $request){

        // Registrar en log el valor enviado desde el formulario
        //Log::info('Valor de id_categoria recibido: ' . $request->input('id_categoria'));
        $request->validate([
            "nombre"=>'required|string|max:255',
            "descripcion"=>'required|string|max:255',
            "stock" => 'required|numeric|min:0',
            "precio" => 'required|numeric|min:0',
            "id_categoria" => 'required|integer|exists:categorias,id_categoria',
            "estado" => 'required|in:activo,inactivo',
            "imagen" => 'required|image|mimes:jpg,jpeg,png|max:5120',
            "imagen1" => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            "imagen2" => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            "imagen3" => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);
        // Obtener configuración de IVA (asumiendo que se identifica por tener valor en iva)
        $ivaConfig = Configuracion::whereNotNull('iva')->first();
        $precioBase=$request->precio;
        $precioConIVA=0;
        if($ivaConfig){
             $IVA=round($ivaConfig->iva, 4);
             $precioConIVA = round(($precioBase * $IVA) + $precioBase, 2); 
            
        }else{
            $precioConIVA=$precioBase;
        }
        $nombreImagen = null;

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreImagen = time() . '_1_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('imagenes'), $nombreImagen);
        }

         // Procesar imágenes adicionales
        $nombreImagen1 = null;
        $nombreImagen2 = null;
        $nombreImagen3 = null;

        if ($request->hasFile('imagen1')) {
            $archivo1 = $request->file('imagen1');
            $nombreImagen1 = time() . '_2_' . $archivo1->getClientOriginalName();
            $archivo1->move(public_path('imagenes'), $nombreImagen1);
        }

        if ($request->hasFile('imagen2')) {
            $archivo2 = $request->file('imagen2');
            $nombreImagen2 = time() . '_3_' . $archivo2->getClientOriginalName();
            $archivo2->move(public_path('imagenes'), $nombreImagen2);
        }

        if ($request->hasFile('imagen3')) {
            $archivo3 = $request->file('imagen3');
            $nombreImagen3 = time() . '_4_' . $archivo3->getClientOriginalName();
            $archivo3->move(public_path('imagenes'), $nombreImagen3);
        }

        Producto::create([
            'nombre_producto' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'url_imagen' => $nombreImagen,
            'url_imagen1' => $nombreImagen1,
            'url_imagen2' => $nombreImagen2,
            'url_imagen3' => $nombreImagen3,
            'stock' => $request->stock,
            'precio' => $precioConIVA,
            'id_categoria' => $request->id_categoria
        ]);
        return redirect()->back()->with('success', 'Producto creado correctamente.');
    }

    public function update(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|integer|exists:productos,id_producto',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
            'precio' => 'required|numeric|min:0',
            'id_categoria' => 'required|integer|exists:categorias,id_categoria',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // Opcional
            "imagen1" => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            "imagen2" => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            "imagen3" => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $producto = Producto::findOrFail($request->input('id_producto'));
            // Obtener configuración de IVA
            $ivaConfig = Configuracion::whereNotNull('iva')->first();
            $precioConIVA=0;
            $precioBase=$request->input('precio');
           
            if($ivaConfig){
                $IVA=round($ivaConfig->iva, 4);
                $precioConIVA = round(($precioBase * $IVA) + $precioBase, 2); 
            }else{
                $precioConIVA=$precioBase;
            }
            // Preparar datos para actualizar
            $data = [
                'nombre_producto' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'stock' => $request->input('stock'),
                'estado' => $request->input('estado'),
                'precio' => $precioConIVA,
                'id_categoria' => $request->input('id_categoria'),
            ];

            // Si se sube nueva imagen
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                if ($archivo->isValid()) {
                    $nombreImagen = time() . '_1_' . $archivo->getClientOriginalName();
                    $archivo->move(public_path('imagenes'), $nombreImagen);
                    $data['url_imagen'] = $nombreImagen;
                }
            }
            // Procesar imagen1
            if ($request->hasFile('imagen1')) {
                $archivo = $request->file('imagen1');
                if ($archivo->isValid()) {
                    $nombreImagen1 = time() . '_2_' . $archivo->getClientOriginalName();
                    $archivo->move(public_path('imagenes'), $nombreImagen1);
                    $data['url_imagen1'] = $nombreImagen1;
                }
            }

            // Procesar imagen2
            if ($request->hasFile('imagen2')) {
                $archivo = $request->file('imagen2');
                if ($archivo->isValid()) {
                    $nombreImagen2 = time() . '_3_' . $archivo->getClientOriginalName();
                    $archivo->move(public_path('imagenes'), $nombreImagen2);
                    $data['url_imagen2'] = $nombreImagen2;
                }
            }

            // Procesar imagen3
            if ($request->hasFile('imagen3')) {
                $archivo = $request->file('imagen3');
                if ($archivo->isValid()) {
                    $nombreImagen3 = time() . '_4_' . $archivo->getClientOriginalName();
                    $archivo->move(public_path('imagenes'), $nombreImagen3);
                    $data['url_imagen3'] = $nombreImagen3;
                }
            }

            

            $producto->update($data);

            DB::commit();
            return back()->with('success', 'Producto actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info("Error al actualizar producto: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el producto.');
        }
    }

    public function busquedaProducto(Request $request){
        $query = $request->input('query');
    
        // Obtener todas las categorías activas (puedes añadir condiciones si es necesario)
        $categorias = Categoria::all();
        
        if ($query) {
            // Búsqueda de productos
            $productos = Producto::where('nombre_producto', 'LIKE', "%{$query}%")
                ->orWhere('descripcion', 'LIKE', "%{$query}%")
                ->where('estado', 'activo') // Solo productos activos
                ->with('categorias') // Carga la relación de categorías
                ->paginate(12);
        } else {
            // Todos los productos si no hay búsqueda
            $productos = Producto::where('estado', 'activo')
                ->with('categorias')
                ->paginate(12);
        }
        
        return view('productos', compact('productos', 'query', 'categorias'));
    }

    public function buscarProductosFiltros(Request $request){
        $query = $request->input('query');
        $categories = $request->input('categories', []);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        
        // Obtener todas las categorías para el filtro
        $categorias = Categoria::all();
        
        // Consulta base
        $productosQuery = Producto::where('estado', 'activo')
            ->with('categorias');
        
        // Aplicar búsqueda de texto si existe
        if ($query) {
            $productosQuery->where(function($q) use ($query) {
                $q->where('nombre_producto', 'LIKE', "%{$query}%")
                ->orWhere('descripcion', 'LIKE', "%{$query}%");
            });
        }
        
        // Aplicar filtro de categorías si se seleccionaron (y no está marcado "Todas")
        if (!empty($categories) && !$request->has('category_all')) {
            $productosQuery->whereIn('id_categoria', $categories);
        }
        
        // Aplicar filtro de precio mínimo
        if ($minPrice) {
            $productosQuery->where('precio', '>=', $minPrice);
        }
        
        // Aplicar filtro de precio máximo
        if ($maxPrice) {
            $productosQuery->where('precio', '<=', $maxPrice);
        }
        
        // Paginar resultados
        $productos = $productosQuery->paginate(12);
        
        return view('productos', compact('productos', 'query', 'categorias'));
    }

    public function mostrarDetallesProducto($id)
    {
        $producto = Producto::with('categorias')->findOrFail($id);
        return view('producto-detalle', compact('producto'));
    }

    public function tablaProductosFiltrados(Request $request)
    {
        $query = Producto::with('categorias');
        
        // Filtro por categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('id_categoria', $request->categoria);
        }
        
        // Filtro por stock
        if ($request->has('stock') && $request->stock != '') {
            switch ($request->stock) {
                case 'in-stock':
                    $query->where('stock', '>', 15);
                    break;
                case 'low-stock':
                    $query->whereBetween('stock', [6, 15]);
                    break;
                case 'critical-stock':
                    $query->whereBetween('stock', [1, 5]);
                    break;
                case 'out-of-stock':
                    $query->where('stock', 0);
                    break;
            }
        }
        
        $productos = $query->paginate(3);
        $productos->appends($request->except('page'));
        
        return view('admin-productos-tabla', compact('productos'));
    }
}
