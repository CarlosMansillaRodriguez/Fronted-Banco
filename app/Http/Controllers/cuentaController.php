<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class cuentaController extends Controller
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
            // Consumir la API externa para obtener todas las cuentas
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($urlApi . '/cuentas');
            //dd($response->getStatusCode(), $response->body(), $response->json());
            if ($response->successful()) {
                $cuentas = $response->json();
                return view('cuentas.index', compact('cuentas'));
            } else {
                return back()->withErrors('Error al obtener las cuentas.');
            }
        } catch (\Exception $e) {
            return back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
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
            // Obtener todos los clientes
            $responseClientes = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($urlApi . '/clientes');
    
            if (!$responseClientes->successful()) {
                return back()->withErrors('Error al obtener los clientes.');
            }
    
            $clientes = $responseClientes->json();
    
            // Obtener todos los usuarios
            $responseUsuarios = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($urlApi . '/usuarios');
    
            if (!$responseUsuarios->successful()) {
                return back()->withErrors('Error al obtener los usuarios.');
            }
    
            $usuarios = $responseUsuarios->json();
    
            // Convertir usuarios a colección indexada por id para búsqueda rápida
            $usuariosColeccion = collect($usuarios)->keyBy('id');
    
            // Agregar información del usuario a cada cliente
            $clientesConUsuario = collect($clientes)->map(function ($cliente) use ($usuariosColeccion) {
                $clienteId = $cliente['id'] ?? null;
                $usuarioId = $cliente['usuario_id'] ?? null;
    
                $cliente['usuario'] = $usuarioId && $usuariosColeccion->has($usuarioId)
                    ? $usuariosColeccion->get($usuarioId)
                    : null;
    
                return $cliente;
            });
            
            //dd($clientesConUsuario);
            // Pasar todos los clientes (con su usuario asociado) a la vista
            return view('cuentas.create', [
                'clientes' => $clientesConUsuario->values()->all()
            ]);
    
        } catch (\Exception $e) {
            return back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }
            // Validación con $request->validate()
            $validatedData = $request->validate([
                // Datos del usuario
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'genero' => 'required|in:M,F',
                'fecha_nacimiento' => 'required|date|before:today',
                'email' => 'required|email',
                'nombre_user' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
    
                // Datos del cliente
                'ci' => 'required|integer',
                'telefono' => 'required|integer',
                'direccion' => 'required|string|max:255',
    
                // Datos de la cuenta
                'tipo_de_cuenta' => 'required|in:Ahorro,Corriente',
                'moneda' => 'required|string|in:BOB,USD',
                'intereses' => 'nullable|numeric|min:0|max:99.99',
                'limite_de_retiro' => 'nullable|numeric|min:0',
                'numero_cuenta' => 'required|string',
                'fecha_de_apertura' => 'required|date',
                'saldo' => 'required|numeric|min:0',
            ]);
    
    
        try {
            // Consumir la API externa para crear una nueva cuenta
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->post($urlApi . '/cuentas', $validatedData);

    
            if ($response->successful()) {
                return redirect()->route('cuentas.index')->with('success', 'Cuenta aperturada exitosamente.');
            } else {
                return back()->withErrors(['error' => 'Error al registrar: ' . $response->body()])->withInput();
            }
    
        } catch (\Exception $e) {
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
    $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');

    if (!$token) {
        return redirect()->route('login')->withErrors('No estás autenticado.');
    }

    try {
        // Llamar a la API para obtener los datos de la cuenta por ID
        $responseCuenta = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($urlApi . '/cuentas/' . $id);

        if ($responseCuenta->successful()) {
            $cuenta = $responseCuenta->json();

            // Si la cuenta no tiene cliente_id
            if (empty($cuenta['cliente_id'])) {
                return back()->withErrors('La cuenta seleccionada no tiene un titular asignado.');
            }

            // Obtener datos del cliente
            $clienteId = $cuenta['cliente_id'];
            $responseCliente = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($urlApi . '/clientes/' . $clienteId);

            if (!$responseCliente->successful()) {
                return back()->withErrors('Error al obtener los datos del cliente.');
            }

            $cliente = $responseCliente->json();

            // Obtener datos del usuario asociado al cliente
            $usuarioId = $cliente['usuario_id'] ?? null;
            if ($usuarioId) {
                $responseUsuario = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ])->get($urlApi . '/usuarios/' . $usuarioId);

                if ($responseUsuario->successful()) {
                    $usuario = $responseUsuario->json();
                    $cliente['usuario'] = $usuario; // Agregar el usuario al cliente
                } else {
                    $cliente['usuario'] = null;
                }
            } else {
                $cliente['usuario'] = null;
            }

             // Agregar el cliente con su usuario dentro de la estructura de la cuenta
            $cuenta['cliente'] = $cliente;
            
            /*
            // Obtener todos los clientes disponibles para el select
            $responseClientes = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($urlApi . '/clientes');

            $clientesDisponibles = $responseClientes->successful() 
                ? collect($responseClientes->json())->all() 
                : []; */
            //dd($cuenta);   
            return view('cuentas.edit', compact('cuenta'));

        } else {
            return back()->withErrors('Error al obtener los datos de la cuenta.');
        }

    } catch (\Exception $e) {
        return back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
    }
}


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        // Obtener URL de la API desde .env y token de sesión
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['error' => 'No autenticado']);
        }

        // Validación básica antes de enviar a la API
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'genero' => 'required|in:M,F',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email',
            'nombre_user' => 'required|string|max:255',
            'ci' => 'required|integer',
            'telefono' => 'required|integer',
            'direccion' => 'required|string',
            'tipo_de_cuenta' => 'required|string|in:Ahorro,Corriente',
            'moneda' => 'required|in:BOB,USD',
            'intereses' => 'required|numeric',
            'limite_de_retiro' => 'required|numeric',
            'saldo' => 'required|numeric',
            'numero_cuenta' => 'nullable|string',
            'fecha_de_apertura' => 'nullable|date',
            'password' => 'nullable|string|min:6|confirmed',
        ]);


        try {
            // Asegúrate de que $urlApi no termine en /api
            // La ruta completa se construye aquí
            $urlCompleta = "{$urlApi}/cuentas/{$id}";

            // Enviar solicitud PUT a la API con headers personalizados
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->put($urlCompleta, [
                // Datos del usuario
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'genero' => $validatedData['genero'],
                'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                'email' => $validatedData['email'],
                'nombre_user' => $validatedData['nombre_user'],
                'password' => $validatedData['password'], // Puede ser null

                // Datos del cliente
                'ci' => $validatedData['ci'],
                'telefono' => $validatedData['telefono'],
                'direccion' => $validatedData['direccion'],

                // Datos de la cuenta
                'tipo_de_cuenta' => $validatedData['tipo_de_cuenta'],
                'moneda' => $validatedData['moneda'],
                'intereses' => $validatedData['intereses'],
                'limite_de_retiro' => $validatedData['limite_de_retiro'],
                'saldo' => $validatedData['saldo'],
                'numero_cuenta' => $validatedData['numero_cuenta'],
                'fecha_de_apertura' => $validatedData['fecha_de_apertura'],
            ]);


            // Si la API responde con éxito
            if ($response->successful()) {
                return redirect()->route('cuentas.index')
                    ->with('success', 'Cuenta actualizada exitosamente.');
            }

            return back()
                ->withErrors(['error' => 'Error al actualizar la cuenta: ' . $response->body()])
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocurrió un error al conectar con la API: ' . $e->getMessage()])
                ->withInput();
        }
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        // URL del servidor de la API
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');

        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }

        try {
            // Llamar a la API para eliminar o restaurar la cuenta
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->delete($urlApi . '/cuentas/' . $id);

            if ($response->successful()) {
                // Redirigir al índice con mensaje de éxito
                return redirect()->route('cuentas.index')->with('success', $response->json()['message']);
            }

            // Si hay errores de validación (422)
            if ($response->status() === 422) {
                return back()
                    ->withErrors($response->json()['errors'] ?? [])
                    ->withInput();
            }

            // Mensaje genérico por si no hay mensaje específico
            return back()
                ->withErrors('Error al actualizar la cuenta: ' . $response->body())
                ->withInput();

        } catch (\Exception $e) {
            return back()
                ->withErrors('Error al conectar con la API: ' . $e->getMessage())
                ->withInput();
        }
    }
}
