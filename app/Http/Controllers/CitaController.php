<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    public function index()
    {
        try {
            $citas = Cita::with('mascota')->get();
            return view('citas.index', compact('citas'));
        } catch (\Exception $e) {
            Log::error("Error al obtener las citas: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener las citas'], 500);
        }
    }

    public function create()
    {
        $mascotas = Mascota::all();
        $servicios =Servicio::all();


        return view('citas.create', compact('mascotas', 'servicios'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'mascota_id' => 'sometimes|exists:mascotas,id',
                'servicio_id' => 'sometimes|exists:servicios,id',
                'fecha_hora' => 'required|date_format:Y-m-d\TH:i',
                'estado' => 'sometimes|string|in:pendiente,confirmada,completada,cancelada',
            ]);

            $cita = Cita::create($request->all());

            return redirect()->route('citas.index')->with('Mensaje', 'Cita agregada exitosamente');
        } catch (\Exception $e) {
            Log::error("Error al crear la cita: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al crear la cita'], 500);
        }
    }

    public function edit( $id)
    {
        $cita = Cita::findOrFail($id);
        $mascotas = Mascota::all();
        $servicios = Servicio::all();

        return view('citas.edit', compact('cita', 'mascotas', 'servicios'));
    }
    public function show(string $id)
    {
        try {
            $cita = Cita::with('mascota')->findOrFail($id);
            return response()->json($cita, 200);
        } catch (\Exception $e) {
            Log::error("Error al mostrar la cita: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al mostrar la cita'], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $cita = Cita::findOrFail($id);

            $request->validate([
                'mascota_id' => 'sometimes|exists:mascotas,id',
                'servicio_id' => 'sometimes|exists:servicios,id',
                'fecha_hora' => 'required|date_format:Y-m-d\TH:i',
                'estado' => 'sometimes|string|in:pendiente,confirmada,finalizada,cancelada',
            ]);

            $cita->update($request->all());

            return redirect()->route('citas.index')->with('Mensaje', 'Cita actualizada exitosamente');
        } catch (\Exception $e) {
            Log::error("Error al actualizar la cita: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al actualizar la cita'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error("Error al eliminar la cita: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al eliminar la cita'], 500);
        }
    }

    public function indexWithTrashed()
    {
        try {
            $citas = Cita::withTrashed()->get();
            return response()->json($citas, 200);
        } catch (\Exception $e) {
            Log::error("Error al obtener todas las citas, incluidos los eliminados: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener las citas'], 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $cita = Cita::withTrashed()->findOrFail($id);
            $cita->restore();
            return response()->json($cita, 200);
        } catch (\Exception $e) {
            Log::error("Error al restaurar la cita: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al restaurar la cita'], 500);
        }
    }
}
