@push('styles')
    @vite('resources/css/formulario.css')
@endpush

<form action="{{ $Modo == 'crear' ? url('/servicios') : url('/servicios/'.$servicio->id) }}" method="POST">
    @csrf
    @if($Modo == 'editar')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Servicio:</label>
        <input type="text" name="nombre" class="form-control" required
        value="{{ isset($servicio->nombre) ? $servicio->nombre : '' }}">
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea name="descripcion" class="form-control" required>{{ isset($servicio->descripcion) ? $servicio->descripcion : '' }}</textarea>
    </div>



    <div class="mb-3">
        <label for="precio" class="form-label">Precio:</label>
        <input type="number" name="precio" class="form-control" required
        value="{{ isset($servicio->precio) ? $servicio->precio : '' }}">
    </div>

    <input type="submit" class="btn btn-success" value="{{ $Modo == 'crear' ? 'Agregar Servicio' : 'Modificar Servicio' }}">

    <a href="{{ url('/servicios') }}" class="btn btn-primary mb-3">Regresar</a>
</form>
