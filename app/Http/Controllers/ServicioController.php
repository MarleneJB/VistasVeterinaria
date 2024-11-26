<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServicioController extends Controller
{
    public function index()
    {
        try {
            $servicios = Servicio::all();
            return view('servicios.index', compact('servicios'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar los servicios: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('servicios.create');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric|min:0',
            ]);

            Servicio::create($request->all());

            return redirect()->route('servicios.index')->with('success', 'Servicio creado con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar el servicio: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            return view('servicios.show', compact('servicio'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('servicios.index')->with('error', 'Servicio no encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('servicios.index')->with('error', 'Error al mostrar el servicio: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            return view('servicios.edit', compact('servicio'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('servicios.index')->with('error', 'Servicio no encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('servicios.index')->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric|min:0',
            ]);

            $servicio = Servicio::findOrFail($id);
            $servicio->update($request->all());

            return redirect()->route('servicios.index')->with('success', 'Servicio actualizado con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('servicios.index')->with('error', 'Servicio no encontrado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el servicio: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            $servicio->delete();

            return redirect()->route('servicios.index')->with('success', 'Servicio eliminado con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('servicios.index')->with('error', 'Servicio no encontrado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el servicio: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $servicio = Servicio::withTrashed()->findOrFail($id);
            $servicio->restore();

            return redirect()->route('servicios.index')->with('success', 'Servicio restaurado correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('servicios.index')->with('error', 'Servicio no encontrado para restaurar.');
        } catch (\Exception $e) {
            return redirect()->route('servicios.index')->with('error', 'Error al restaurar el servicio: ' . $e->getMessage());
        }
    }
}
