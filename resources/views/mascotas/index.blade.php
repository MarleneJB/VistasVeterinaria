@extends('layout.app')

@push('styles')
    @vite('resources/css/mascotas.css')
@endpush


@section('content')

<div class="container">
        @if (Session::has('Mensaje')){{
        Session::get('Mensaje')
         }}
        @endif
    <h1>Administrar Mascotas</h1>

    <a href="{{ url('/mascotas/create') }}" class="btn btn-primary mb-3">Agregar Nueva Mascota</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Dueño</th>
                <th>Teléfono</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mascotas as $mascota)
            <tr>
                <td>{{ $mascota->id }}</td>
                <td>{{ $mascota->nombre }}</td>
                <td>{{ $mascota->especie }}</td>
                <td>{{ $mascota->raza }}</td>
                <td>{{ $mascota->edad }}</td>
                <td>{{ $mascota->nombre_dueno }}</td>
                <td>{{ $mascota->telefono }}</td>
                <td>
                    @if ($mascota->imagen)
                       <img src="{{ $mascota->imagen }}" alt="Imagen de {{ $mascota->nombre }}" width="200">
                    @else
                        No disponible
                    @endif
                </td>
                <td>
                    <a href="{{ route('mascotas.edit', $mascota->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('mascotas.destroy', $mascota->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta mascota?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
