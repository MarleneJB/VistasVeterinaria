<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Servicio;
use App\Models\Cita;
use Illuminate\Http\Request;

class TrashedController extends Controller
{
    public function index(Request $request)
    {
        try {
            $mascotas = Mascota::onlyTrashed()->get();
            $servicios = Servicio::onlyTrashed()->get();
            $citas = Cita::onlyTrashed()->get();

            return view('trashed.index', compact('mascotas', 'servicios', 'citas'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar los elementos eliminados: ' . $e->getMessage());
        }
    }
}
