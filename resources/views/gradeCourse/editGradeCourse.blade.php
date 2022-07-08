@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Editar Curso</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'listGradeCourse' ) }}" class="btn btn-primary float-right">Voltar</a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" action="{{ route( 'updateGradeCourse' ) }}">
    @csrf

    <select class="custom-select mb-3" name="grade">
        <option value="0" selected>Selecione o Grau</option>
        @foreach ( $grades as $grade )
            <option
                value="{{ $grade->id }}"
                {{ $gradeCourse->grade_id === $grade->id ? 'selected' : '' }}
            >{{ $grade->description }}</option>
        @endforeach
    </select>

    <select class="custom-select mb-3" name="area">
        <option value="0" selected>Selecione a Área</option>
        @foreach ( $areas as $area )
            <option
                value="{{ $area->id }}"
                {{ $gradeCourse->area_id === $area->id ? 'selected' : '' }}
            >{{ $area->description }}</option>
        @endforeach
    </select>

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Descrição</span>
        </div>
        <input level="text" class="form-control" name="description" value="{{ $gradeCourse->description }}">
        <input type="hidden" name="id" value="{{ $gradeCourse->id }}">
    </div>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
