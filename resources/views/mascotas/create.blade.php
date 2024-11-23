@extends('layout.app')

@section('content')
<div class="container">
    <h1>Crear Mascota</h1>
    <form action="{{ url('/mascotas') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('mascotas.form', ['Modo'=>'crear'])
</form>
</div>
@endsection
