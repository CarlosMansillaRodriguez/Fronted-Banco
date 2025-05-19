<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }
    
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->get($urlApi . '/usuarios');
    
            if ($response->successful()) {
                $usuarios = $response->json();
                // Si también necesitas roles únicos
                $roles = collect($usuarios)->flatMap(function ($usuario) {
                    return $usuario['roles'];
                })->unique('id')->values();
                //dd($usuarios);
                return view('users.index', compact('usuarios', 'roles'));
            } else {
                return back()->withErrors('Error al obtener usuarios: ' . $response->body());
            }
        } catch (\Exception $e) {
            return back()->withErrors('Error de conexión con la API: ' . $e->getMessage());
        }        
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');

        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->get($urlApi . '/roles');

            if ($response->successful()) {
                $roles = $response->json();

                return view('users.create', compact('roles'));
            } else {
                return back()->withErrors('Error al obtener roles: ' . $response->body());
            }
        } catch (\Exception $e) {
            return back()->withErrors('Error de conexión con la API: ' . $e->getMessage());
        }
        /* $roles = Role::all();
        return view('users.create', compact('roles')); */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $apiUrl = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');

    // Validación de datos antes de enviar a la API
    $validatedData = $request->validate([
        'nombre_user' => 'required|string|max:100',
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed',
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'genero' => 'required|string|max:1',
        'fecha_nacimiento' => 'required|date',
        'roles' => 'required|array|min:1'
    ]);

    try {
        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post($apiUrl . '/usuarios', [
            'nombre_user' => $validatedData['nombre_user'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'roles' => $validatedData['roles'],
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'genero' => $validatedData['genero'],
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
        ]);

        // Si la respuesta es exitosa
        if ($response->successful()) {
            return redirect()->route('users.index')
                ->with('success', 'Usuario creado correctamente.');
        }

        // Si hay errores de validación (422 Unprocessable Entity)
        if ($response->status() === 422) {
            $errors = $response->json()['errors'] ?? [];

            return back()
                ->withErrors($errors)
                ->withInput();
        }

        // Si hay cualquier otro error
        $message = $response->json()['message'] ?? 'Error desconocido';

        return back()
            ->with('error', $message)
            ->withInput();

    } catch (\Exception $e) {
        // Manejar fallos en la conexión o ejecución de la solicitud HTTP
        return back()
            ->with('error', 'Error al conectar con la API: ' . $e->getMessage())
            ->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');

    if (!$token) {
        return redirect()->route('login')->withErrors('No estás autenticado.');
    }

    //try {
        // Obtener datos del usuario desde la API
        $responseUser = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get($urlApi . '/usuarios/' . $id);
        //dd($responseUser->getStatusCode(), $responseUser->body(), $responseUser->json());
        if (!$responseUser->successful()) {
            return back()->withErrors('Error al obtener los datos del usuario.');
        }

        $user = $responseUser->json();
        //dd($user);
        // Obtener todos los roles desde la API
        $responseRoles = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get($urlApi . '/roles');

        if (!$responseRoles->successful()) {
            return back()->withErrors('Error al obtener los roles.');
        }

        $roles = $responseRoles->json();
        
        return view('users.edit', compact('user', 'roles'));

    //} catch (\Exception $e) {
    //    return back()->withErrors('Error de conexión con la API: ' . $e->getMessage());
    //}
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');

    if (!$token) {
        return redirect()->route('login')->withErrors('No estás autenticado.');
    }

    try {
        // Preparar los datos a enviar
        $data = [];
        //dd($request);
        // Si no se proporciona contraseña, no la incluimos
        if (empty($request->password)) {
            $data = Arr::except($request->all(), ['password']);
        } else {
            // Hashear la contraseña si se proporciona
            //$data['password'] = Hash::make($request->password);
            // Incluir otros campos
            $data = $request->only(['nombre_user', 'email','nombre','apellido','genero','fecha_nacimiento','roles']) + ['password' => $data['password']];
        }
        //dd($data);
        // Llamar a la API para actualizar el usuario
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->patch($url . '/usuarios/' . $id, $data);
        //dd($response->getStatusCode(), $response->body(), $response->json());
        // Verificar respuesta exitosa
        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario editado correctamente.');
        }
        Log::info($request->all());
        // Si hay errores de validación por parte de la API
        if ($response->status() === 422) {
            return back()
                ->withErrors($response->json()['errors'] ?? [])
                ->withInput();
        }

        return back()->withErrors('Error al actualizar el usuario.');

    } catch (\Exception $e) {
        return back()->withErrors('Error de conexión con la API: ' . $e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');
    
    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete($url . '/usuarios/' . $id);
        
        $responseData = $response->json();
        
        if ($response->successful()) {
            return redirect()->route('users.index')
                ->with('success', $responseData['message']);
        }
        
        return back()->with('error', $responseData['error'] ?? 'Error al cambiar estado');
        
    } catch (\Exception $e) {
        //Log::error('Error al cambiar estado de usuario: ' . $e->getMessage());
        return back()->with('error', 'Error de conexión: ' . $e->getMessage());
    }

    }
}
