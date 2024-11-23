@extends('layout.app')

@push('styles')
    @vite('resources/css/servicios.css')
@endpush

@section('content')

<div class="container">
    @if (Session::has('Mensaje'))
        {{ Session::get('Mensaje') }}
    @endif
    <h1>Administrar Servicios</h1>

    <a href="{{ route('servicios.create') }}" class="btn btn-primary mb-3">Agregar Nuevo Servicio</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->nombre }}</td>
                    <td>{{ $servicio->descripcion }}</td>
                    <td>${{ number_format($servicio->precio, 2) }}</td>
                    <td>
                        <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este servicio?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
