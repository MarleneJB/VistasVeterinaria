@extends('layout.app')

@push('styles')
    @vite('resources/css/citas.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/fullcalendar.min.css">
@endpush

@section('content')
<div class="container mt-4">
    @if (Session::has('Mensaje'))
        <div class="alert alert-success">
            {{ Session::get('Mensaje') }}
        </div>
    @endif

    <h1 class="mb-4">Administrar Citas</h1>
    <a href="{{ url('/citas/create') }}" class="btn btn-primary mb-3">Agregar Nueva Cita</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mascota</th>
                <th>Servicio</th>
                <th>Fecha y Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
            <tr>
                <td>{{ $cita->id }}</td>
                <td>{{ $cita->mascota->nombre ?? 'Sin asignar' }}</td>
                <td>{{ $cita->servicio->nombre??'Sin asignar' }}</td>
                <td>{{ $cita->fecha_hora }}</td>
                <td>{{ ucfirst($cita->estado) }}</td>
                <td>
                    <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta cita?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="calendar" class="mt-5"></div>
</div>
@endsection


