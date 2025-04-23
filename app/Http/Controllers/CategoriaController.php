<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "nombre" => 'required|string|max:255',
            "descripcion" => 'required|string|max:255',
            "id_padre" => 'nullable|exists:categorias,id_categoria'
        ]);
        Log::info("Categoria",["Id_padre"=>$request->id_padre]);

        Categoria::create([
            'nombre_categoria' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_padre' => $request->id_padre
        ]);

        return redirect()->back()->with('success', 'Categoría creada exitosamente');
    }

    public function createCategoriaView(){
        $categorias = Categoria::whereNull('id_padre')->get();
        return view('admin-crear-categoria', compact('categorias'));
    } 
}
