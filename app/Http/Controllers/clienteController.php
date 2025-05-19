<?php

namespace App\Http\Controllers;

//use App\Http\Requests\UpdateClienteRequest;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class clienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    
        try {
            // Obtener el token de autenticación (asegúrate de almacenarlo previamente en la sesión o en otro lugar seguro)
            $token = session('auth_token'); // Cambia esto según dónde almacenes el token
    
            // Consumir la API externa con el token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url . '/clientes');
            
            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $clientes = $response->json();
                //dd($clientes);
                return view('clientes.index', compact('clientes'));
            }
            
            // Si la respuesta no es exitosa, manejar el error
            return redirect()->back()->withErrors('No se pudo obtener la lista de clientes desde la API.');
        } catch (Exception $e) {
            // Manejar excepciones
            return redirect()->back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         Log::info('Iniciando método store para crear cliente');
         $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
         $token = session('auth_token');
         Log::debug('URL API: '.$url);
         Log::debug('Token de sesión: '.substr($token ?? 'null', 0, 10).'...'); // Mostramos solo parte del token por seguridad
        
         // Validar datos del cliente y su usuario asociado
         try {
             Log::info('Validando datos del formulario');
             $validatedData = $request->validate([
                'ci' => 'required|numeric',
                'direccion' => 'required|string|max:255',
                'telefono' => 'required|numeric',
                'nombre_user' => 'required|string|max:50',
                'email' => 'required|email',
                'password' => 'required|string|min:8|same:password_confirm',
                'nombre' => 'required|string|max:50', // Añadir estos campos
                'apellido' => 'required|string|max:50',
                'genero' => 'required|string',
                'fecha_nacimiento' => 'required|date',
             ]);
             
             Log::debug('Datos validados correctamente', $validatedData);
         } catch (\Illuminate\Validation\ValidationException $e) {
             Log::error('Error de validación: '.$e->getMessage());
             throw $e; // Laravel manejará esto y redirigirá con los errores
         }
     
         if (!$token) {
             Log::warning('Intento de acceso no autenticado');
             return redirect()->route('login')->withErrors('No estás autenticado.');
         }
     
         try {
             // Armar el payload para enviar a la API
             $payload = [
                 'ci' => $request->input('ci'),
                 'direccion' => $request->input('direccion'),
                 'telefono' => $request->input('telefono'),
                 /*' usuario' => [ */
                     'nombre_user' => $request->input('nombre_user'),
                     'email' => $request->input('email'),
                     'password' => bcrypt($request->input('password')),
                     'nombre' => $request->input('nombre'),
                     'apellido' => $request->input('apellido'),
                     'genero' => $request->input('genero'),
                     'fecha_nacimiento' => $request->input('fecha_nacimiento'),
                 //],
             ];
             
             Log::debug('Payload preparado para la API', ['payload' => $payload]);
     
             Log::info('Realizando petición a la API externa');
             $response = Http::withToken($token)
                 ->acceptJson()
                 ->post("{$url}/clientes", $payload);
                 //dd($response);
             Log::debug('Respuesta de la API', [
                 'status' => $response->status(),
                 'body' => $response->body()
             ]);
     
             if ($response->successful()) {
                 Log::info('Cliente creado exitosamente');
                 Log::debug('Respuesta completa de la API', $response->json());
                 return redirect()->route('clientes.index')
                     ->with('success', 'Cliente creado exitosamente.');
             }
     
             // Si hay error desde la API
             $error = $response->json()['message'] ?? 'Error desconocido';
             Log::error('Error en la respuesta de la API: '.$error, [
                 'status' => $response->status(),
                 'errors' => $response->json()
             ]);
             return back()->withErrors(['api' => 'Error al crear el cliente: ' . $error]);
     
         } catch (\Exception $e) {
             Log::error('Excepción al conectar con la API: '.$e->getMessage(), [
                 'exception' => $e,
                 'trace' => $e->getTraceAsString()
             ]);
             return back()->withErrors(['error' => 'Error al conectar con la API: ' . $e->getMessage()]);
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
    
    public function edit(string $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    
        try {
            // Obtener el token de autenticación desde la sesión
            $token = session('auth_token');
    
            // Verificar si el token está disponible
            if (!$token) {
                return redirect()->route('login')->withErrors('No se encontró el token de autenticación. Por favor, inicia sesión nuevamente.');
            }
    
            // Consumir la API externa para obtener los datos del cliente
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url . '/clientes/' . $id);
    
            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $cliente = $response->json(); // Obtener los datos del cliente
                //dd($cliente);
                // Extraer los datos del usuario si existen
                /* if (isset($cliente['usuario']) && is_array($cliente['usuario'])) {
                    $cliente['nombre_user'] = $cliente['usuario']['nombre_user'] ?? '';
                    $cliente['email'] = $cliente['usuario']['email'] ?? '';
                    unset($cliente['usuario']); // Eliminar el array 'usuario' para evitar confusiones
                } */
                
                return view('clientes.edit', compact('cliente'));
            }
    
            // Manejar errores de la API
            return redirect()->back()->withErrors('Error al obtener los datos del cliente: ' . $response->body());
        } catch (Exception $e) {
            // Manejar excepciones
            return redirect()->back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)
    {
         // Validación de datos del cliente y usuario
        $validated = $request->validate([
            'ci' => 'required|string',
            'telefono' => 'required|integer',
            'direccion' => 'required|string|max:255',
            'nombre_user' => 'required|string|max:100',
            'email' => 'required|email',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'genero' => 'required|string|max:1',
            'fecha_nacimiento' => 'required|date',
            'password' => 'nullable|min:6|confirmed',
        ]);
    
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }
    
        try {
             // Preparar payload para la API
            $payload = [
                'ci' => $validated['ci'],
                'telefono' => $validated['telefono'],
                'direccion' => $validated['direccion'],
                 /* 'usuario' => [ */
                    'nombre_user' => $validated['nombre_user'],
                    'email' => $validated['email'],
                    'nombre' => $validated['nombre'],
                    'apellido' => $validated['apellido'],
                    'genero' => $validated['genero'],
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                 //]
            ];
    
             // Si se proporciona contraseña, inclúyela
            if (!empty($validated['password'])) {
                $payload['usuario']['password'] = bcrypt($validated['password']);
            }
    
             // Hacer solicitud PUT a la API
            $response = Http::withToken($token)
                ->acceptJson()
                ->put("$urlApi/clientes/$id", $payload);
    
            if ($response->failed()) {
                return back()->withErrors(['error' => 'Error al actualizar el cliente: ' . $response->body()]);
            }
    
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al conectar con la API: ' . $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

        try {
            // Obtener el token de autenticación desde la sesión
            $token = session('auth_token');

            // Verificar si el token está disponible
            if (!$token) {
                return redirect()->route('login')->withErrors('No se encontró el token de autenticación. Por favor, inicia sesión nuevamente.');
            }

            // Consumir la API externa para alternar el estado del cliente
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/clientes/' . $id);

            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $data = $response->json();
                return redirect()->route('clientes.index')->with('success', $data['message']);
            }

            // Manejar errores de la API
            return redirect()->back()->withErrors('Error al eliminar/restaurar el cliente: ' . $response->body());
        } catch (Exception $e) {
            // Manejar excepciones
            return redirect()->back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }
}
