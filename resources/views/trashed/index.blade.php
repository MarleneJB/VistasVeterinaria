@extends('layout.app')

@section('title', 'Eliminados')

@section('content')
<div class="container">
    <h2 class="mb-4">Elementos Eliminados</h2>

    <!-- Mascotas Eliminadas -->
    <h3>Mascotas</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dueño</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mascotas as $mascota)
                <tr>
                    <td>{{ $mascota->nombre }}</td>
                    <td>{{ $mascota->dueño }}</td>
                    <td>
                        <form action="{{ route('mascotas.restore', $mascota->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-warning btn-sm">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay mascotas eliminadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Servicios Eliminados -->
    <h3>Servicios</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->nombre }}</td>
                    <td>${{ $servicio->precio }}</td>
                    <td>
                        <form action="{{ route('servicios.restore', $servicio->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-warning btn-sm">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay servicios eliminados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Citas Eliminadas -->
    <h3>Citas</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mascota</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($citas as $cita)
                <tr>
                    <td>{{ $cita->mascota?->nombre ?? 'Sin mascota asociada' }}</td>
                    <td>{{ $cita->fecha }}</td>
                    <td>
                        <form action="{{ route('citas.restore', $cita->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-warning btn-sm">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay citas eliminadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
