<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class permisoController extends Controller
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
            // Llamar al endpoint GET /permisos
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get("{$urlApi}/permisos");

            if ($response->failed()) {
                return back()->withErrors('Error al obtener los permisos desde la API.');
            }

            // Extraer datos del JSON
            $data = $response->json();

            // Asegurarse de que hay datos de permisos
            $permisos = $data['permisos'] ?? [];

            // Pasar los permisos a la vista
            return view('permisos.index', compact('permisos'));

        } catch (\Exception $e) {
            return back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');

    // Validación básica en el frontend
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string'
    ]);

    try {
        // Enviar solicitud POST a la API
        $response = Http::withToken($token)
            ->acceptJson()
            ->post("$urlApi/permisos", $validatedData);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Error al crear el permiso']);
        }

        return back()->with('success', 'Permiso creado correctamente.');

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(Request $request)
{
    $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');
    $token = session('auth_token');

    // Validación del ID y otros campos
    $validatedData = $request->validate([
        'id' => 'required|integer',
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string'
    ]);

    try {
        // Enviar solicitud PUT a la API
        $response = Http::withToken($token)
            ->acceptJson()
            ->put("$urlApi/permisos/{$validatedData['id']}", [
                'nombre' => $validatedData['nombre'],
                'descripcion' => $validatedData['descripcion']
            ]);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Error al actualizar el permiso']);
        }

        return back()->with('success', 'Permiso actualizado correctamente.');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error al conectar con la API: ' . $e->getMessage()]);
    }
} */
public function update(Request $request)
{
    // Recibir el ID desde un campo oculto del formulario
    $validated = $request->validate([
        'id' => 'required|integer',
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string'
    ]);

    $urlApi = env('URL_SERVER_API', 'http://127.0.0.1:8000');

    try {
        $response = Http::withToken(session('auth_token'))
            ->put("{$urlApi}/permisos/{$validated['id']}", [
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion']
            ]);

        if ($response->successful()) {
            return back()->with('success', 'Permiso actualizado correctamente.');
        }

        return back()->withErrors(['error' => 'Error al actualizar el permiso']);
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error al conectar con la API: ' . $e->getMessage()]);
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
            // Construir URL completa
            $endpoint = "$urlApi/permisos/$id";
    
            // Enviar solicitud DELETE a la API
            $response = Http::withToken($token)
                ->acceptJson()
                ->delete($endpoint);
    
            // Verificar si la llamada falló
            if ($response->failed()) {
                return back()->withErrors([
                    'error' => 'Error al eliminar el recurso desde la API.'
                ]);
            }
    
            return back()->with('success', 'Permiso eliminado correctamente.');
    
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al conectar con la API: ' . $e->getMessage()
            ]);
        }
    }
}
