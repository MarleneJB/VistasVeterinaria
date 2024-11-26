<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MascotaController extends Controller
{
    public function index()
    {
        try {
            $mascotas = Mascota::all();

            $mascotas->each(function ($mascota) {
                if ($mascota->imagen) {
                    $mascota->imagen = asset('storage/' . $mascota->imagen);
                }
            });

            return view('mascotas.index', compact('mascotas'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar la lista de mascotas: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('mascotas.create');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'especie' => 'required|string|max:255',
                'raza' => 'required|string|max:255',
                'edad' => 'required|integer|min:0',
                'nombre_dueno' => 'required|string|max:255',
                'telefono' => 'required|string|max:10',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $validatedData['imagen'] = $request->file('imagen')->store('mascotas_imagenes', 'public');
            }

            Mascota::create($validatedData);

            return redirect()->route('mascotas.index')->with('success', 'Mascota creada con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar la mascota: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $mascota = Mascota::findOrFail($id);
            return view('mascotas.show', compact('mascota'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mascotas.index')->with('error', 'Mascota no encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('mascotas.index')->with('error', 'Error al mostrar la mascota: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $mascota = Mascota::findOrFail($id);
            return view('mascotas.edit', compact('mascota'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mascotas.index')->with('error', 'Mascota no encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('mascotas.index')->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'especie' => 'required|string|max:255',
                'raza' => 'required|string|max:255',
                'edad' => 'required|integer|min:0',
                'nombre_dueno' => 'required|string|max:255',
                'telefono' => 'required|string|max:10',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $mascota = Mascota::findOrFail($id);

            if ($request->hasFile('imagen')) {
                if ($mascota->imagen) {
                    Storage::delete('public/' . $mascota->imagen);
                }
                $validatedData['imagen'] = $request->file('imagen')->store('mascotas_imagenes', 'public');
            }

            $mascota->update($validatedData);

            return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mascotas.index')->with('error', 'Mascota no encontrada.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la mascota: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $mascota = Mascota::findOrFail($id);

            if ($mascota->imagen) {
                Storage::delete('public/' . $mascota->imagen);
            }

            $mascota->delete();

            return redirect()->route('mascotas.index')->with('success', 'Mascota eliminada con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mascotas.index')->with('error', 'Mascota no encontrada.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la mascota: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $mascota = Mascota::withTrashed()->findOrFail($id);
            $mascota->restore();

            return redirect()->route('mascotas.index')->with('success', 'Mascota restaurada correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mascotas.index')->with('error', 'Mascota no encontrada para restaurar.');
        } catch (\Exception $e) {
            return redirect()->route('mascotas.index')->with('error', 'Error al restaurar la mascota: ' . $e->getMessage());
        }
    }
}
