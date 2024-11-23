
@extends('layout.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje')){{
        Session::get('Mensaje')
         }}
        @endif
        <h1>Editar Mascota</h1>

        <form action="{{ route('mascotas.update', $mascota->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('mascotas.form', ['Modo'=>'editar'])

        </form>
    </div>
@endsection
