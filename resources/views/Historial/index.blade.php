@extends('layout.app')
@push('styles')
    @vite('resources/css/historial.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/fullcalendar.min.css">
@endpush
@section('content')
    <h1 class="mb-4">Administrar Historial Médico</h1>
    <a href="{{ route('historial.create') }}" class="btn btn-primary mb-3">Agregar Historial de Mascota</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($historiales->isEmpty())
        <p>No hay historiales registrados aún.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mascota</th>
                    <th>Diagnóstico</th>
                    <th>Tratamientos</th>
                    <th>Medicamentos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiales as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->mascota->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $item->diagnostico }}</td>
                    <td>{{ $item->tratamientos }}</td>
                    <td>{{ $item->medicamentos }}</td>
                    <td>
                        <a href="{{ route('historial.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('historial.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este historial?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
