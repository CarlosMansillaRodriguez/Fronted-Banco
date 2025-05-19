<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class logoutController extends Controller
{
    public function logout()
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors('No hay sesión activa.');
        }
    
        try {
            // Consumir la API externa para cerrar sesión
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->post($urlApi . '/logout');
    
            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                // Eliminar token y datos de sesión
                session()->forget('auth_token'); // Opcional: si guardas solo el token
                session()->flush(); // Limpiar toda la sesión
    
                return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
            }
    
            // Si no fue exitosa
            return back()->withErrors('Error al cerrar sesión.');
    
        } catch (\Exception $e) {
            return back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }
}
