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
        $productos = Producto::with('categorias')->paginate(10);
        return view('admin-crear-productos', compact('categorias', 'productos'));
    
    }

    public function searchProducto(Request $request){
        $valorBuscar = $request->input("valor");
        
        $productos = Producto::query()
            ->when($valorBuscar, function($query, $valorBuscar) {
                return $query->where("nombre_producto", "like", "%{$valorBuscar}%");
            })
            ->orderBy("created_at", "desc")
            ->paginate(10)
            ->appends(['search' => $valorBuscar]);
        
        // Obtener las categorías necesarias para el formulario
        $categorias = Categoria::all();
        
        return view("admin-crear-productos", compact("productos", "valorBuscar", "categorias"));
    }
    public function storeOrUpdate(Request $request)
    {
        // Obtener acción e índice de la URL
        $action = $request->input('action');
        $index = $request->input('index');
        
        Log::info("Accion e indice",["Accion:"=>$action,"indice"=>$index]);
        if (!$action || !is_numeric($index)) {
            return redirect()->back()->with('error', 'Acción no especificada');
        }

        // Validación
        $validator = Validator::make($request->all(), [
            "nombre.$index" => 'required|string|max:255',
            "descripcion.$index" => 'required|string|max:255',
            "stock.$index" => 'required|numeric|min:0',
            "estado.$index" => 'required|in:activo,inactivo',
            "precio.$index" => 'required|numeric|min:0',
            "id_categoria.$index" => 'required|integer|exists:categorias,id_categoria',
            "imagen.$index" => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Preparar datos
        $data = [
            'nombre_producto' => $request->input("nombre.$index"),
            'descripcion' => $request->input("descripcion.$index"),
            'stock' => $request->input("stock.$index"),
            'estado' => $request->input("estado.$index"),
            'precio' => $request->input("precio.$index"),
            'id_categoria' => $request->input("id_categoria.$index"),
        ];

        // Manejo de imagen
        if ($request->hasFile("imagen.$index")) {
            $archivo = $request->file("imagen")[$index];
            if ($archivo->isValid()) {
                $nombreImagen = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('imagenes'), $nombreImagen);
                $data['url_imagen'] = $nombreImagen;
            }
        }
        // Registrar la información que se va a procesar
        Log::info("Procesando producto - Acción: {$action}, Índice: {$index}, Datos: " . json_encode($data));


        // Ejecutar acción
        try {
            DB::beginTransaction();
            
            if ($action === 'guardar') {
                $productoId = $request->input("id_producto.$index");
                $producto = Producto::findOrFail($productoId);
                $producto->update($data);
                $mensaje = 'Producto actualizado correctamente.';
            } else { // create
                Producto::create($data);
                $mensaje = 'Producto creado correctamente.';
            }
            
            DB::commit();
            return redirect()->back()->with('success', $mensaje);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en storeOrUpdate: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar la solicitud');
        }
    }
}
