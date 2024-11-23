
@extends('layout.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje')){{
        Session::get('Mensaje')
         }}
        @endif
        <h1>Editar Servicio</h1>

        <form action="{{ route('servicios.update', $servicio->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('servicios.form', ['Modo'=>'editar'])

        </form>
    </div>
@endsection
