@extends('diaristas.app')

@section('titulo', 'Criar Diarista')

@section('conteudo')
        <h1>Criar Diarista</h1>
        <form action="{{ route('diaristas.store') }}" method="POST" enctype="multipart/form-data">
            @include('diaristas._form')
        </form>
@endsection 