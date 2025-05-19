<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class empleadoController extends Controller
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
            ])->get($url . '/empleados');
            
            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $empleados = $response->json();
                //dd($empleados);
                return view('empleados.index', compact('empleados'));
            }
            
            // Si la respuesta no es exitosa, manejar el error
            return redirect()->back()->withErrors('No se pudo obtener la lista de empleados desde la API.');
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
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Iniciando método store para crear ');
         $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
         $token = session('auth_token');
         Log::debug('URL API: '.$url);
         Log::debug('Token de sesión: '.substr($token ?? 'null', 0, 10).'...'); // Mostramos solo parte del token por seguridad
        
         // Validar datos del cliente y su usuario asociado
         try {
             Log::info('Validando datos del formulario');
             $validatedData = $request->validate([
                'nombre_user' => 'required|string|max:50',
                'email' => 'required|email',
                'password' => 'required|string|min:8|same:password_confirm',
                'nombre' => 'required|string|max:50', // Añadir estos campos
                'apellido' => 'required|string|max:50',
                'genero' => 'required|string',
                'fecha_nacimiento' => 'required|date',
                'cargo' => 'required|string|max:100',
                'fecha_contrato' => 'required|date',
                'horario_entrada' => 'required|time|max:10',
                'horario_salida' => 'required|time|max:10',
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
                'cargo' => $request->input('cargo'),
                'horario_entrada' => $request->input('horario_entrada'),
                'horario_salida' => $request->input('horario_salida'),
                'fecha_contrato' => $request->input('fecha_contrato'),
                'nombre_user' => $request->input('nombre_user'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'nombre' => $request->input('nombre'),
                'apellido' => $request->input('apellido'),
                'genero' => $request->input('genero'),
                'fecha_nacimiento' => $request->input('fecha_nacimiento'),
             ];
             
             Log::debug('Payload preparado para la API', ['payload' => $payload]);
     
             Log::info('Realizando petición a la API externa');
             $response = Http::withToken($token)
                 ->acceptJson()
                 ->post("{$url}/empleados", $payload);
                 //dd($response);
             Log::debug('Respuesta de la API', [
                 'status' => $response->status(),
                 'body' => $response->body()
             ]);
     
             if ($response->successful()) {
                 Log::info('Empleado creado exitosamente');
                 Log::debug('Respuesta completa de la API', $response->json());
                 return redirect()->route('empleados.index')
                     ->with('success', 'Empleado creado exitosamente.');
             }
     
             // Si hay error desde la API
             $error = $response->json()['message'] ?? 'Error desconocido';
             Log::error('Error en la respuesta de la API: '.$error, [
                 'status' => $response->status(),
                 'errors' => $response->json()
             ]);
             return back()->withErrors(['api' => 'Error al crear el empleado: ' . $error]);
     
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

            // Consumir la API externa para alternar el estado del empleado
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/empleados/' . $id);

            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                $data = $response->json();
                return redirect()->route('empleados.index')->with('success', $data['message']);
            }

            // Manejar errores de la API
            return redirect()->back()->withErrors('Error al eliminar/restaurar el empleado: ' . $response->body());
        } catch (Exception $e) {
            // Manejar excepciones
            return redirect()->back()->withErrors('Error al conectar con la API: ' . $e->getMessage());
        }
    
    }
}
