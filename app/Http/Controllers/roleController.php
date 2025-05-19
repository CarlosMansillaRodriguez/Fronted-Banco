<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

        try {
            // Obtener el token de autenticación desde la sesión
            $token = session('auth_token');

            // Verificar si el token está disponible
            if (!$token) {
                return redirect()->route('login')->withErrors('No se encontró el token de autenticación. Por favor, inicia sesión nuevamente.');
            }

            // Consumir la API externa para obtener los roles
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url . '/roles');

            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $roles = $response->json(); // Obtener los datos de los roles

                return view('roles.index', compact('roles'));
            }
            
            // Manejar errores de la API
            return redirect()->back()->withErrors('Error al obtener los roles: ' . $response->body());
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
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

        try {
            // Obtener el token de autenticación desde la sesión
            $token = session('auth_token');

            // Verificar si el token está disponible
            if (!$token) {
                return redirect()->route('login')->withErrors('No se encontró el token de autenticación. Por favor, inicia sesión nuevamente.');
            }

            // Consumir la API externa para obtener los permisos
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url . '/permisos');

            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $apiResponse  = $response->json(); // Obtener los datos de los permisos
                
                $permisos = $apiResponse['permisos'] ?? []; // Si no hay permisos, asigna un array vacío

                return view('roles.create', compact('permisos'));
            }

            // Manejar errores de la API
            return redirect()->back()->withErrors('Error al obtener los permisos: ' . $response->body());
        } catch (Exception $e) {
            // Manejar excepciones
            return redirect()->back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        // Obtener el token de autenticación desde la sesión
        $token = session('auth_token');
        //dd($request);
    // Validar los datos del formulario
    $request->validate([
        'nombre' => 'required|string',
        'descripcion' => 'nullable|string',
        'permisos' => 'required|array|min:1',
        'permisos.*' => 'integer'
    ]);

    try {
        
        if (!$token) {
            return redirect()->route('login')->withErrors('No se encontró el token de autenticación.');
        }
        
        // Preparar los datos para enviar a la API
        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'permisos' => $request->permisos // Asegúrate que coincida con lo que espera la API
        ];

        //dd($data); // Descomenta cuando esté todo listo

        // Consumir la API externa para crear el rol
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post($url . '/roles', $data);

        // Verificar si la respuesta fue exitosa
        if ($response->successful()) {
            $responseData = $response->json();
            //dd($responseData); // Descomenta cuando esté todo listo
            return redirect()->route('roles.index')->with('success', $responseData['message'] ?? 'Rol creado correctamente.');
        }
        // Si hay errores de validación (422)
        if ($response->status() === 422) {
            return back()
                ->withErrors($response->json()['errors'] ?? [])
                ->withInput();
        }
    } catch (Exception $e) {
        return back()
            ->withErrors('Error al crear el rol: ' . $e->getMessage())
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

    public function edit(string $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

        try {
            // Obtener el token de autenticación desde la sesión
            $token = session('auth_token');

            if (!$token) {
                return redirect()->route('login')->withErrors('No se encontró el token de autenticación. Por favor, inicia sesión nuevamente.');
            }

            // Obteniendo permisos disponibles
            $permisosResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url . '/permisos');

            if ($permisosResponse->successful()) {
                $permisos = $permisosResponse->json()['permisos'] ?? [];
            } else {
                return redirect()->back()->withErrors('Error al obtener los permisos.');
            }

            // Obteniendo datos del rol
            $rolResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url . "/roles/{$id}");

            if ($rolResponse->successful()) {
                $rolData = $rolResponse->json();

                // Verificar que el rol tenga estructura esperada
                if (!isset($rolData['id'])) {
                    return redirect()->route('roles.index')->withErrors('Formato de respuesta inesperado al obtener el rol.');
                }

                $role = $rolData;

                // Obteniendo permisos asignados al rol
                $permisosAsignadosResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->get($url . "/roles/{$id}/permisos");

                if ($permisosAsignadosResponse->successful()) {
                    $permisosAsignados = $permisosAsignadosResponse->json()['data'] ? array_column($permisosAsignadosResponse->json()['data'], 'id') : [];
                } else {
                    $permisosAsignados = [];
                }

                return view('roles.edit', compact('role', 'permisos', 'permisosAsignados'));
            }

            return redirect()->back()->withErrors('Error al obtener los datos del rol.');

        } catch (Exception $e) {
            return redirect()->back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    

    public function update(Request $request, string $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
        $token = session('auth_token');

        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'permisos' => 'required|array|min:1',
            'permisos.*' => 'integer'
        ]);

        try {
            if (!$token) {
                return redirect()->route('login')->withErrors('No se encontró el token de autenticación.');
            }

            // Preparar los datos para enviar a la API
            $data = [
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'] ?? null,
                'permisos' => $validated['permisos']
            ];

            // Actualizar el rol
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->put("{$url}/roles/{$id}", $data);

            // Si no fue exitoso, devolvemos error
            if (!$response->successful()) {
                $errorMessage = $response->json()['message'] ?? 'Error desconocido';
                return back()->withErrors($errorMessage);
            }

            // Extraer respuesta JSON
            $responseData = $response->json();

            return redirect()->route('roles.index')->with('success', $responseData['message'] ?? 'Rol actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withErrors('Ocurrió un error al intentar actualizar el rol.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');

        // Obtener el token de autenticación desde la sesión
        $token = session('auth_token');

        if (!$token) {
            return redirect()->route('login')->withErrors('No se encontró el token de autenticación.');
        }

        // Realizar petición DELETE a la API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->delete("{$url}/roles/{$id}");

        // Verificar si la respuesta fue exitosa
        if ($response->successful()) {
            $responseData = $response->json();
            $message = $responseData['message'] ?? 'Rol eliminado correctamente.';
            return redirect()->route('roles.index')->with('success', $message);
        }

        // Si hay error 409 (rol con usuarios asignados)
        if ($response->status() === 409) {
            $errorMessage = $response->json()['message'] ?? 'El rol no puede ser eliminado.';
            return redirect()->back()->withErrors($errorMessage);
        }

        // Otros errores
        $errorMessage = $response->json()['message'] ?? 'Ocurrió un error al intentar eliminar el rol.';
        return redirect()->back()->withErrors($errorMessage);
    }
}
