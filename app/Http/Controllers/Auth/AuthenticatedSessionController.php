<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Obtener el usuario autenticado
        $user = Auth::user();

        Log::info('Usuario autenticado:', [
            'id' => $user->id_usuario,
            'nombre' => $user->nombre,
            'rol' => $user->rol->tipo_rol]);
         // Depuración
        // if (!Auth::check()) {
        //     Log::info('La autenticacion fallo:', [
        //         'id' => $user->id,
        //         'nombre' => $user->nombre,
        //         'rol' => $user->rol->tipo_rol]);
        //     return back()->withErrors(['email' => 'Authentication failed']);
        // }
        
        // Redirigir al panel de inventario por defecto (accesible para todos)
        if($user->rol->tipo_rol=="administrador"){
            return redirect()->route('admin.dashboard-admin');
        }
        Log::info("Redirigiendo a user.dashboard");
        return redirect()->route('user.dashboard-usuario');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
