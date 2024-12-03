@extends('layout.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje')){{
        Session::get('Mensaje')
         }}
        @endif
        <h1>Editar Historial</h1>

        <form action="{{ route('historial.update', $historial->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('historial.form', ['Modo'=>'editar'])

        </form>
    </div>
@endsection
