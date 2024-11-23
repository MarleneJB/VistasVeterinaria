<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalendarCitaController extends Controller
{
    public function calendarEvents()
    {
        try {
            $citas = Cita::with('mascota')->get();

            $events = $citas->map(function ($cita) {
                return [
                    'id' => $cita->id,
                    'title' => $cita->servicio . ' - ' . ($cita->mascota->nombre ?? 'Sin asignar'),
                    'start' => $cita->fecha_hora,
                    'description' => $cita->estado,
                    'url' => route('citas.edit', $cita->id),
                    'className' => 'event-' . $cita->estado,
                ];
            });

            return response()->json($events, 200);
        } catch (\Exception $e) {
            Log::error("Error al obtener los eventos del calendario: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener los eventos'], 500);
        }
    }

    public function storeCalendarEvent(Request $request)
    {
        try {
            $request->validate([
                'mascota_id' => 'required|exists:mascotas,id',
                'servicio' => 'required|string|max:255',
                'fecha_hora' => 'required|date_format:Y-m-d H:i:s|after:now',
                'estado' => 'nullable|string|in:pendiente,confirmada,completada,cancelada',
            ]);

            $cita = Cita::create($request->all());
            return response()->json($cita, 201);
        } catch (\Exception $e) {
            Log::error("Error al crear el evento desde el calendario: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al crear el evento'], 500);
        }
    }

    public function updateCalendarEvent(Request $request, string $id)
    {
        try {
            $cita = Cita::findOrFail($id);

            $request->validate([
                'fecha_hora' => 'required|date_format:Y-m-d H:i:s|after:now',
                'estado' => 'nullable|string|in:pendiente,confirmada,completada,cancelada',
            ]);

            $cita->update($request->only(['fecha_hora', 'estado']));
            return response()->json($cita, 200);
        } catch (\Exception $e) {
            Log::error("Error al actualizar el evento desde el calendario: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al actualizar el evento'], 500);
        }
    }

    public function deleteCalendarEvent(string $id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error("Error al eliminar el evento desde el calendario: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al eliminar el evento'], 500);
        }
    }
}
