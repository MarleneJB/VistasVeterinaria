@extends('layout.app')

@section('content')
<div class="container">
    <h1>Crear Mascota</h1>
    <form action="{{ url('/citas') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('citas.form', ['Modo'=>'crear'])
</form>
</div>
@endsection
