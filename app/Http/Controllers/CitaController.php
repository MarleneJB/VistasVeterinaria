<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CitaController extends Controller
{
    public function index()
    {
        try {
            $citas = Cita::with('mascota', 'servicio')->get();
            return view('citas.index', compact('citas'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener las citas: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $mascotas = Mascota::all();
            $servicios = Servicio::all();
            return view('citas.create', compact('mascotas', 'servicios'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'mascota_id' => 'required|exists:mascotas,id',
                'servicio_id' => 'required|exists:servicios,id',
                'fecha_hora' => 'required|date',
                'estado' => 'nullable|string',
            ]);

            Cita::create($request->all());
            return redirect()->route('citas.index')->with('success', 'Cita creada con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la cita: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $cita = Cita::findOrFail($id);
            return view('citas.show', compact('cita'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('citas.index')->with('error', 'Cita no encontrada.');
        } catch (Exception $e) {
            return redirect()->route('citas.index')->with('error', 'Error al mostrar la cita: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $mascotas = Mascota::all();
            $servicios = Servicio::all();
            return view('citas.edit', compact('cita', 'mascotas', 'servicios'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('citas.index')->with('error', 'Cita no encontrada.');
        } catch (Exception $e) {
            return redirect()->route('citas.index')->with('error', 'Error al cargar la edición: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'mascota_id' => 'required|exists:mascotas,id',
                'servicio_id' => 'required|exists:servicios,id',
                'fecha_hora' => 'required|date',
                'estado' => 'nullable|string',
            ]);

            $cita = Cita::findOrFail($id);
            $cita->update($request->all());
            return redirect()->route('citas.index')->with('success', 'Cita actualizada con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('citas.index')->with('error', 'Cita no encontrada.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la cita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();
            return redirect()->route('citas.index')->with('success', 'Cita eliminada con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('citas.index')->with('error', 'Cita no encontrada.');
        } catch (Exception $e) {
            return redirect()->route('citas.index')->with('error', 'Error al eliminar la cita: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $cita = Cita::withTrashed()->findOrFail($id);
            $cita->restore();

            return redirect()->route('trashed.index')->with('success', 'Cita restaurada correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('trashed.index')->with('error', 'Cita no encontrada.');
        } catch (Exception $e) {
            return redirect()->route('trashed.index')->with('error', 'Error al restaurar la cita: ' . $e->getMessage());
        }
    }
}
