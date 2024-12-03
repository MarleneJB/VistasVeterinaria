@extends('layout.app')

@section('content')
<div class="container">
    <h1>Crear Historial</h1>
    <form action="{{ url('/historial') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('historial.form', ['Modo'=>'crear'])
</form>
</div>
@endsection
