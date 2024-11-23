@push('styles')
    @vite('resources/css/formulario.css')
@endpush

<div class="mb-3">
    <label for="mascota_id" class="form-label">Mascota:</label>
    <select name="mascota_id" class="form-control" required>
        <option value="">Seleccionar Mascota</option>
        @foreach ($mascotas as $mascota)
            <option value="{{ $mascota->id }}"
                {{ isset($cita->mascota_id) && $cita->mascota_id == $mascota->id ? 'selected' : '' }}>
                {{ $mascota->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="servicio_id" class="form-label">Servicio:</label>
    <select name="servicio_id" class="form-control" required>
        <option value="">Seleccionar servicio</option>
        @foreach ($servicios as $servicio)
            <option value="{{ $servicio->id }}"
                {{ isset($cita->servicio_id) && $cita->servicio_id == $servicio->id ? 'selected' : '' }}>
                {{ $servicio->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="fecha_hora" class="form-label">Fecha y Hora:</label>
    <input type="datetime-local" name="fecha_hora" class="form-control" required
       value="{{ isset($cita->fecha_hora) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cita->fecha_hora)->format('Y-m-d\TH:i') : '' }}">
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado:</label>
    <select name="estado" class="form-control" required>
        <option value="pendiente" {{ isset($cita->estado) && $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="confirmada" {{ isset($cita->estado) && $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
        <option value="finalizada" {{ isset($cita->estado) && $cita->estado == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
        <option value="cancelada" {{ isset($cita->estado) && $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
    </select>
</div>


<input type="submit" class="btn btn-success" value="{{ $Modo == 'crear' ? 'Agregar Cita' : 'Modificar Cita' }}">

<a href="{{ url('/citas') }}" class="btn btn-primary mb-3">Regresar</a>
