<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        try {
            $servicios = Servicio::all();

            if ($request->ajax()) {
                return response()->json($servicios, 200);
            }


            return view('servicios.index', compact('servicios'));

        } catch (\Exception $e) {
            Log::error("Error al obtener los servicios: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener los servicios'], 500);
        }
    }

    public function create()
    {
      return view('servicios.create');
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:1000',
                'precio' => 'required|numeric|min:0',
            ]);

            $servicio = Servicio::create($request->all());

            return redirect()->route('servicios.index')->withErrors(['error' => 'Servicio no agregado']);
        } catch (\Exception $e) {
            Log::error("Error al crear el servicio: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al crear el servicio'], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            return response()->json($servicio, 200);
        } catch (\Exception $e) {
            Log::error("Error al mostrar el servicio: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al mostrar el servicio'], 500);
        }
    }


    public function edit($id)
    {
        try {
            // Buscar la mascota por su ID
            $servicio = Servicio::findOrFail($id);

            // Retornar la vista con los datos de la mascota
            return view('servicios.edit', compact('servicio'));
        } catch (\Exception $e) {
            Log::error("Error al cargar el formulario de edición: " . $e->getMessage());

            // Enviar al usuario un error si no se encuentra la mascota
            return redirect()->route('servicios.index')->withErrors(['error' => 'Servicio no encontrado.']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $servicio = Servicio::findOrFail($id);

            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'nullable|string|max:1000',
                'precio' => 'sometimes|numeric|min:0',
            ]);

            $servicio->update($request->all());

            return redirect()->route('servicios.index')->withErrors(['error' => 'Servicio no encontrado.']);
        } catch (\Exception $e) {
            Log::error("Error al actualizar el servicio: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al actualizar el servicio'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            $servicio->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error("Error al eliminar el servicio: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al eliminar el servicio'], 500);
        }
    }

    public function indexWithTrashed()
    {
        try {
            $servicios = Servicio::withTrashed()->get();
            return response()->json($servicios, 200);
        } catch (\Exception $e) {
            Log::error("Error al obtener todos los servicios, incluidos los eliminados: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener los servicios'], 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $servicio = Servicio::withTrashed()->findOrFail($id);
            $servicio->restore();
            return response()->json($servicio, 200);
        } catch (\Exception $e) {
            Log::error("Error al restaurar el servicio: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al restaurar el servicio'], 500);
        }
    }
}
