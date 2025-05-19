<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class tarjetaController extends Controller
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
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($urlApi . '/tarjetas');
            //dd($response->getStatusCode(), $response->body(), $response->json());
            if ($response->successful()) {
                $data = $response->json();
                 $tarjetas = $data['tarjetas']; // Extraemos solo el array de tarjetas
                //dd($tarjetas);
                return view('tarjetas.index', compact('tarjetas'));
            } else {
                return back()->withErrors('Error al obtener las tarjetas.');
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
            // Llamada a la API para obtener todas las cuentas
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get("{$urlApi}/cuentas");
    
            if ($response->successful()) {
                $cuentas = $response->json(); // Suponemos que devuelve un array de cuentas
    
                // Pasar las cuentas a la vista
                //dd($cuentas);
                return view('tarjetas.create', compact('cuentas'));
            } else {
                return back()->withErrors(['error' => 'Error al obtener las cuentas: ' . $response->body()]);
            }
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al conectar con la API: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    // Registrar inicio de la solicitud
    Log::info("Inicio de registro de tarjeta", [
        'ip' => $request->ip(),
        'usuario' => session('nombre_user') ?? 'no autenticado',
        'input' => $request->except(['cvc']) // Evitar guardar cvc en log
    ]);

    $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');
    //dd($request->all());
    if (!$token) {
        Log::warning("Intento de registro sin token de autenticación", [
            'ip' => $request->ip()
        ]);
        return redirect()->route('login')->withErrors(['error' => 'No autenticado']);
    }

    try {
        // Validación básica del frontend
        $validatedData = $request->validate([
            'numero' => 'required|string|size:16',
            'tipo' => 'required|string|in:Crédito,Débito',
            'cvc' => 'required|string|size:3',
            'fecha_vencimiento' => 'required|date|after_or_equal:today',
            'estado' => 'required|string',
            'cuenta_id' => 'required|numeric'
        ]);

        Log::info("Datos validados correctamente para registrar tarjeta", [
            'datos_validados' => $validatedData
        ]);

        // Enviar solicitud POST a la API
        $response = Http::withToken($token)
            ->acceptJson()
            ->post("{$urlApi}/tarjetas", $validatedData);

        Log::info("Solicitud enviada a la API", [
            'url' => "{$urlApi}/tarjetas",
            'status' => $response->status(),
            'respuesta' => $response->json() ?? $response->body()
        ]);

        if ($response->failed()) {
            $errorData = $response->json();

            // Manejo especial para errores de validación (422)
            if ($response->status() === 422) {
                $errorMessage = collect($errorData['errors'] ?? [])
                    ->flatten()
                    ->first() ?? 'Error de validación en los datos';

                Log::notice("Error de validación al registrar tarjeta", [
                    'errores' => $errorData['errors'] ?? 'Sin detalles',
                    'status' => $response->status()
                ]);

                return back()->withInput()
                    ->with('error', $errorMessage);
            }

            // Otros tipos de errores
            Log::error("Error al registrar tarjeta", [
                'mensaje' => $errorData['message'] ?? 'Error desconocido',
                'status' => $response->status()
            ]);

            return back()->withInput()
                ->with('error', $errorData['message'] ?? 'Error al procesar la solicitud');
        }

        Log::info("Tarjeta registrada exitosamente", [
            'respuesta_api' => $response->json()
        ]);

        return redirect()->route('tarjetas.index')
            ->with('success', 'Tarjeta registrada exitosamente');

    } catch (\Exception $e) {
        Log::error("Excepción durante el registro de tarjeta", [
            'error' => $e->getMessage(),
            //'archivo' => $e->getFile(),
            'línea' => $e->getLine()
        ]);

        return back()->withInput()
            ->with('error', 'Ocurrió un error al conectar con la API: ' . $e->getMessage());
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
            // Obtener tarjeta por ID desde la API
            $responseTarjeta = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get("$urlApi/tarjetas/$id");

            if (!$responseTarjeta->successful()) {
                return back()->withErrors('Error al obtener los datos de la tarjeta.');
            }

            $tarjeta = $responseTarjeta->json();

            // Obtener cuentas para mostrar clientes con cuenta asociada
            $responseCuentas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get("$urlApi/cuentas");

            if (!$responseCuentas->successful()) {
                return back()->withErrors('Error al obtener las cuentas.');
            }

            $cuentas = collect($responseCuentas->json());
            return view('tarjetas.edit', compact('tarjeta', 'cuentas'));

        } catch (\Exception $e) {
            return back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }
    
        $validatedData = $request->validate([
            'numero' => 'required|string|size:16',
            'tipo' => 'required|string|in:Crédito,Débito',
            'cvc' => 'required|string|size:3',
            'fecha_vencimiento' => 'required|date',
            'cuenta_id' => 'required|integer'
        ]);
    
        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->put("$urlApi/tarjetas/$id", $validatedData);
    
            if ($response->failed()) {
                $errorData = $response->json();
                return back()->withInput()->with('error', $errorData['message'] ?? 'Error al actualizar la tarjeta.');
            }
    
            return redirect()->route('tarjetas.index')->with('success', 'Tarjeta actualizada correctamente.');
    
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al conectar con la API: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors('No estás autenticado.');
        }
    
        try {
            // Llamar al endpoint DELETE /tarjetas/{id}
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->delete($urlApi . '/tarjetas/' . $id);
    
            // Verificar si hubo un error
            if ($response->failed()) {
                $errorData = $response->json();
                return back()->with('error', $errorData['message'] ?? 'Error al cambiar el estado de la tarjeta.');
            }
    
            // Respuesta exitosa
            $responseData = $response->json();
    
            // Mostrar mensaje según el nuevo estado
            $message = $responseData['message'];
    
            return back()->with('success', $message);
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error al conectar con la API: ' . $e->getMessage());
        }
    }
}
