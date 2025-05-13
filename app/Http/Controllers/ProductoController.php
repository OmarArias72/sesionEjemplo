<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
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
        
        Log::info("Producto encontrado",["Nombre"=>$productoEncontrado->nombre_producto]);
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
            "imagen" => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $nombreImagen = null;

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('imagenes'), $nombreImagen);
        }

        Producto::create([
            'nombre_producto' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'url_imagen' => $nombreImagen,
            'stock' => $request->stock,
            'precio' => $request->precio,
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $producto = Producto::findOrFail($request->input('id_producto'));

            // Preparar datos para actualizar
            $data = [
                'nombre_producto' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'stock' => $request->input('stock'),
                'estado' => $request->input('estado'),
                'precio' => $request->input('precio'),
                'id_categoria' => $request->input('id_categoria'),
            ];

            // Si se sube nueva imagen
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                if ($archivo->isValid()) {
                    $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
                    $archivo->move(public_path('imagenes'), $nombreImagen);
                    $data['url_imagen'] = $nombreImagen;
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
        
        return view('productos', compact('productos', 'query'));
    }

    public function mostrarDetallesProducto($id)
    {
        $producto = Producto::with('categorias')->findOrFail($id);
        return view('producto-detalle', compact('producto'));
    }
}
