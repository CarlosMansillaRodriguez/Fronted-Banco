<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('panel');
        }
        return view('auth.login');
    }



   /*  public function login(request $request)
    {
        // URL del servidor de la API
    $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

    // Enviar solicitud POST a la API
    $response = Http::post($url . '/login', [
        'email' => $request->input('email'),
        'password' => $request->input('password'),
    ]);

    // Decodificar respuesta JSON
    $data = $response->json();

    // Verificar si la respuesta es exitosa y contiene los datos esperados
    if ($response->successful() && isset($data['usuario']) && isset($data['token'])) {
        $usuario = $data['usuario'];
        $token = $data['token']; // Obtener el token de la respuesta

        // Guardar el token en la sesión
        session(['auth_token' => $token]);

        // Autenticar al usuario en Laravel
        $user = User::updateOrCreate(
            ['email' => $usuario['email']], // Buscar por email
            [
                'name' => $usuario['nombre_user'], // Actualizar o crear datos
                'password' => bcrypt('default_password'), // Contraseña ficticia
            ]
        );

        Auth::login($user); // Autenticar al usuario

        // Redirigir al dashboard con mensaje de éxito
        return redirect()->route('panel')->with('success', 'Bienvenido, ' . $usuario['nombre_user']);
    } else {
        // Credenciales inválidas o error en la API
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->onlyInput('email');
    }
        
    } */
    /* public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
    
        // URL del servidor de la API
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    
        // Enviar solicitud POST a la API
        $response = Http::post($url . '/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
    
        // Verificar si la respuesta fue exitosa
        if ($response->successful()) {
            $data = $response->json();
    
            // Verificar que la respuesta tenga usuario y token
            if (isset($data['usuario']) && isset($data['token'])) {
                $usuario = $data['usuario'];
                $token = $data['token'];
    
                // Guardar el token en la sesión
                session(['auth_token' => $token]);
    
                // Crear o actualizar el usuario local para mostrar con Laravel Auth
                $user = User::updateOrCreate(
                    ['email' => $usuario['email']],
                    ['name' => $usuario['nombre_user']]
                );
    
                // Autenticar al usuario
                Auth::login($user);
    
                // Redirigir al panel con mensaje de éxito
                return redirect()->route('panel')->with('success', 'Bienvenido, ' . $usuario['nombre_user']);
            } else {
                // Error: La API no devolvió los campos esperados
                return back()->withErrors([
                    'email' => 'Error al iniciar sesión. Inténtalo de nuevo.'
                ])->onlyInput('email');
            }
        } else {
            // Credenciales inválidas o error en la API
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no son válidas.',
            ])->onlyInput('email');
        }
    } */


    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // URL del servidor de la API
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

        // Enviar solicitud POST a la API
        $response = Http::post($url . '/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Guardar el token en sesión
            session(['auth_token' => $data['token']]);

            // Redirigir al panel con mensaje de éxito
            return redirect()->route('panel')->with('success', 'Bienvenido, ' . $data['usuario']['nombre_user']);
        } else {
            // Credenciales inválidas o error en la API
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no son válidas.',
            ])->onlyInput('email');
        }
    }
}
