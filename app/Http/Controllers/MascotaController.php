<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class MascotaController extends Controller
{
    public function index(Request $request)
    {

        try {
            $mascotas = Mascota::all();

            $mascotas->each(function ($mascota) {
                if ($mascota->imagen) {
                    $mascota->imagen = asset('storage/' . $mascota->imagen);
                }
            });
            if ($request->ajax()) {
                // Si la solicitud es AJAX, retorna JSON
                return response()->json($mascotas, 200);
            }

            return view('mascotas.index', compact('mascotas'));


        } catch (\Exception $e) {
            Log::error("Error al obtener las mascotas: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener las mascotas'], 500);

        }

    }

        public function create()
        {
          return view('mascotas.create');
        }



    public function show(string $id)
    {
        try {
            $mascota = Mascota::findOrFail($id);

            if ($mascota->imagen) {
                $mascota->imagen = asset('storage/' . $mascota->imagen);
            }

            return response()->json($mascota, 200);
        } catch (\Exception $e) {
            Log::error("Error al mostrar la mascota: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al mostrar la mascota'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'especie' => 'required|string|max:50',
                'raza' => 'nullable|string|max:50',
                'edad' => 'required|integer',
                'nombre_dueno' => 'required|string|max:100',
                'telefono' => 'required|string|max:15',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            ]);


            $imagenPath = null;
            if ($request->hasFile('imagen')) {

                $imagenPath = $request->file('imagen')->store('imagenes/mascotas', 'public');
            }

            $mascota = Mascota::create(array_merge($request->all(), ['imagen' => $imagenPath]));



            return redirect()->route('mascotas.index')->with('Mensaje', 'Mascota creada exitosamente.');
        } catch (\Exception $e) {
            Log::error("Error al crear la mascota: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al crear la mascota'], 500);
        }
    }

    public function edit($id)
{
    try {
        // Buscar la mascota por su ID
        $mascota = Mascota::findOrFail($id);

        // Retornar la vista con los datos de la mascota
        return view('mascotas.edit', compact('mascota'));
    } catch (\Exception $e) {
        Log::error("Error al cargar el formulario de edición: " . $e->getMessage());

        // Enviar al usuario un error si no se encuentra la mascota
        return redirect()->route('mascotas.index')->withErrors(['error' => 'Mascota no encontrada.']);
    }
}

    public function update(Request $request, string $id)
    {
        try {
            $mascota = Mascota::findOrFail($id);

            $request->validate([
                'nombre' => 'sometimes|string|max:100',
                'especie' => 'sometimes|string|max:50',
                'raza' => 'nullable|string|max:50',
                'edad' => 'sometimes|integer',
                'nombre_dueno' => 'sometimes|string|max:100',
                'telefono' => 'sometimes|string|max:15',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('imagen')) {
                if ($mascota->imagen) {
                    Storage::disk('public')->delete($mascota->imagen);
                }
                $mascota->imagen = $request->file('imagen')->store('imagenes/mascotas', 'public');
            }

            $mascota->update($request->except('imagen'));
            return redirect()->route('mascotas.index')->with('Mensaje', 'Mascota actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar la mascota: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al actualizar la mascota'], 500);
        }
    }


    public function destroy(string $id)
    {
        try {
            $mascota = Mascota::findOrFail($id);
            $mascota->delete();

            return redirect()->route('mascotas.index')->with('success', 'Mascota eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar la mascota: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al eliminar la mascota'], 500);
        }
    }

    public function indexWithTrashed()
    {
        try {
            $mascotas = Mascota::withTrashed()->get();
            return response()->json($mascotas, 200);
        } catch (\Exception $e) {
            Log::error("Error al obtener todas las mascotas, incluidos los eliminados: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener las mascotas'], 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $mascota = Mascota::withTrashed()->findOrFail($id);
            $mascota->restore();
            return response()->json($mascota, 200);
        } catch (\Exception $e) {
            Log::error("Error al restaurar la mascota: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al restaurar la mascota'], 500);
        }
    }
}
