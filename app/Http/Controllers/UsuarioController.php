<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function getViewMiPerfil(){
        return view("user-dashboard");
    }

    public function getEditarPerfil(){
        return view("user-editar-perfil");
    }

    public function getEditarDireccion(){
        return view("user-editar-direccion");
    }

    public function getMisPedidos(){
        return view("user-mis-pedidos");
    }

    public function updatePerfil(Request $request){
        $user = Auth::user();
        
        // Validación de datos
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'regex:/^[0-9]+$/'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                Rule::unique('usuarios', 'email')->ignore($user->id_usuario, 'id_usuario')
            ]
        ]);

        try {
            // Actualizar los datos del usuario
            User::where('id_usuario', $user->id_usuario)->update($validatedData);

            // Redireccionar con mensaje de éxito
            return redirect()->back()->with([
                'status' => 'Perfil actualizado',
                'message' => 'Perfil actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la actualización
            return redirect()->back()->with([
                'status' => 'Actualizacion fallida',
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ])->withInput();
        }

    }
    public function updateDireccion(Request $request){
        $user = Auth::user();
        
        // Validación de datos
        $validatedData = $request->validate([
            'calle' => ['required', 'string', 'max:255'],
            'colonia' => ['required', 'string', 'max:255'],
            'numeroExterior' => ['string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:255'],
            'codigoPostal' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:255'],
            'pais' => ['required', 'string', 'max:255'],
            
            
        ]);

        try {
            // Obtener o crear la dirección del usuario
            $direccion = $user->direccion ?? new Direccion();
            
            // Actualizar los datos de dirección
            $direccion->fill($validatedData);
            $direccion->id_usuario = $user->id_usuario;
            $direccion->save();
    
            // Redireccionar con mensaje de éxito
            return redirect()->back()->with([
                'status' => 'exito',
                'message' => 'Dirección actualizada correctamente'
            ]);
    
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la actualización
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Error al actualizar la dirección: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
