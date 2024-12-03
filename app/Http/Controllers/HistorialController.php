<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class HistorialController extends Controller
{
    public function index()
    {
        try {
            $historiales = Historial::with('mascota')->get();
            return view('historial.index', compact('historiales'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener el historial médico de las mascotas: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $mascotas = Mascota::all();
            return view('historial.create', compact('mascotas'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'mascota_id' => 'required|exists:mascotas,id',
                'diagnostico' => 'required|string|max:255',
                'tratamientos' => 'nullable|string',
                'medicamentos' => 'nullable|string',
            ], [
                'mascota_id.required' => 'Debe seleccionar una mascota.',
                'diagnostico.required' => 'El diagnóstico es obligatorio.',
                'diagnostico.max' => 'El diagnóstico no debe exceder 255 caracteres.',
            ]);

            Historial::create($request->all());
            return redirect()->route('historial.index')->with('success', 'Historial creado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el historial: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $historial = Historial::with('mascota')->findOrFail($id);
            return view('historial.show', compact('historial'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('historial.index')->with('error', 'Historial no encontrado.');
        } catch (Exception $e) {
            return redirect()->route('historial.index')->with('error', 'Error al mostrar el historial: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $historial = Historial::findOrFail($id);
            $mascotas = Mascota::all();
            return view('historial.edit', compact('historial', 'mascotas'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('historial.index')->with('error', 'Historial no encontrado.');
        } catch (Exception $e) {
            return redirect()->route('historial.index')->with('error', 'Error al cargar la edición: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'mascota_id' => 'required|exists:mascotas,id',
                'diagnostico' => 'required|string|max:255',
                'tratamientos' => 'nullable|string',
                'medicamentos' => 'nullable|string',
            ], [
                'mascota_id.required' => 'Debe seleccionar una mascota.',
                'diagnostico.required' => 'El diagnóstico es obligatorio.',
                'diagnostico.max' => 'El diagnóstico no debe exceder 255 caracteres.',
            ]);

            $historial = Historial::findOrFail($id);
            $historial->update($request->all());
            return redirect()->route('historial.index')->with('success', 'Historial actualizado con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('historial.index')->with('error', 'Historial no encontrado.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el historial: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $historial = Historial::findOrFail($id);
            $historial->delete();
            return redirect()->route('historial.index')->with('success', 'Historial eliminado con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('historial.index')->with('error', 'Historial no encontrado.');
        } catch (Exception $e) {
            return redirect()->route('historial.index')->with('error', 'Error al eliminar el historial: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $historial = Historial::withTrashed()->findOrFail($id);
            $historial->restore();
            return redirect()->route('historial.index')->with('success', 'Historial restaurado correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('historial.index')->with('error', 'Historial no encontrado.');
        } catch (Exception $e) {
            return redirect()->route('historial.index')->with('error', 'Error al restaurar el historial: ' . $e->getMessage());
        }
    }

    public function trashed()
    {
        try {
            $historiales = Historial::onlyTrashed()->with('mascota')->get();
            return view('historial.trashed', compact('historiales'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener el historial eliminado: ' . $e->getMessage());
        }
    }
}
