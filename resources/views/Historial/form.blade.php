@push('styles')
    @vite('resources/css/formulario.css')
@endpush

<div class="mb-3">
    <label for="mascota_id" class="form-label">Mascota:</label>
    <select name="mascota_id" class="form-control" required>
        <option value="">Seleccionar Mascota</option>
        @foreach ($mascotas as $mascota)
            <option value="{{ $mascota->id }}"
                {{ isset($historial->mascota_id) && $historial->mascota_id == $mascota->id ? 'selected' : '' }}>
                {{ $mascota->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="especie" class="form-label">Especie:</label>
    <input type="text" name="especie" class="form-control" required
        value="{{ isset($historial->mascota->especie) ? $historial->mascota->especie : '' }}">
</div>

<div class="mb-3">
    <label for="diagnostico" class="form-label">Diagnóstico:</label>
    <input type="text" name="diagnostico" class="form-control" required
        value="{{ isset($historial->diagnostico) ? $historial->diagnostico : '' }}">
</div>

<div class="mb-3">
    <label for="tratamientos" class="form-label">Tratamientos:</label>
    <input type="text" name="tratamientos" class="form-control" required
        value="{{ isset($historial->tratamientos) ? $historial->tratamientos : '' }}">
</div>

<div class="mb-3">
    <label for="medicamentos" class="form-label">Medicamentos:</label>
    <input type="text" name="medicamentos" class="form-control" required
        value="{{ isset($historial->medicamentos) ? $historial->medicamentos : '' }}">
</div>

<input type="submit" class="btn btn-success" value="{{ $Modo == 'crear' ? 'Agregar Historial' : 'Modificar historial' }}">

<a href="{{ url('/historial') }}" class="btn btn-primary mb-3">Regresar</a>
