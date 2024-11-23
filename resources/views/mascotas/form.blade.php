@push('styles')
    @vite('resources/css/formulario.css')
@endpush

<div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required
            value="{{ isset($mascota->nombre) ? $mascota->nombre : '' }}">
        </div>

        <div class="mb-3">
            <label for="especie" class="form-label">Especie:</label>
            <input type="text" name="especie" class="form-control" required
            value="{{ isset($mascota->especie) ? $mascota->especie : '' }}">
        </div>

        <div class="mb-3">
            <label for="raza" class="form-label">Raza:</label>
            <input type="text" name="raza" class="form-control"
            value="{{ isset($mascota->raza) ? $mascota->raza : '' }}">
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad:</label>
            <input type="number" name="edad" class="form-control" required
            value="{{ isset($mascota->edad) ? $mascota->edad : '' }}">
        </div>
        <div class="mb-3">
            <label for="nombre_dueno" class="form-Slabel">Nombre del Dueño:</label>
            <input type="text" name="nombre_dueno" class="form-control" required
            value="{{ isset($mascota->nombre_dueno) ? $mascota->nombre_dueno : '' }}">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control" required
            value="{{ isset($mascota->telefono) ? $mascota->telefono : '' }}">
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen:</label>
            @if(isset($mascota->imagen))
            <br/>
                <img src="{{ asset('storage/'. $mascota->imagen) }}" alt="Imagen de {{ $mascota->nombre }}" width="150" >
            <br/>
            @endif
            <input type="file" name="imagen" class="form-control">

        </div>
        <input type="submit" class="btn btn-success" value="{{$Modo=='crear' ? 'Agregar mascota' : 'Modificar mascota'}}"</button>

        <a href="{{ url('/mascotas') }}" class="btn btn-primary mb-3">Regresar</a>
