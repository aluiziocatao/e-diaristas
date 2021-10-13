@extends('diaristas.app')

@section('titulo', 'Editar Diarista')

@section('conteudo')
        <h1>Editar Diarista</h1>
        <form action="{{ route('diaristas.update', $diarista) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('diaristas._form')           
        </form>
@endsection