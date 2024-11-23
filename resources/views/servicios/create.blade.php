@extends('layout.app')

@section('content')
<div class="container">
    <h1>Crear Servicio</h1>
    <form action="{{ url('/servicios') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('servicios.form', ['Modo'=>'crear'])
</form>
</div>
@endsection
