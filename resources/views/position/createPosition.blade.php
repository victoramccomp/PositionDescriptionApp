@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Adicionar Posição</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'listPosition' ) }}" class="btn btn-primary float-right">Voltar</a>
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

<form method="post" action="{{ route( 'storePosition' ) }}">
    @csrf

    <select class="custom-select mb-3" name="positiongroup">
        <option value="0" selected>Selecione o Grupo da Posição</option>
        @foreach ( $positionGroups as $positionGroup )
            <option value="{{ $positionGroup->id }}">{{ $positionGroup->description }}</option>
        @endforeach
    </select>

    <select class="custom-select mb-3" name="directorate">
        <option value="0" selected>Selecione a Diretoria</option>
        @foreach ( $directorates as $directorate )
            <option value="{{ $directorate->id }}">{{ $directorate->description }}</option>
        @endforeach
    </select>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Descrição</span>
        </div>
        <input type="text" class="form-control" name="description">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Código da posição</span>
        </div>
        <input type="text" class="form-control" name="code">
    </div>

    <div class="input-group" style="display: none;">
        <div class="input-group-prepend">
            <span class="input-group-text">Grade Salarial</span>
        </div>
        <input type="text" class="form-control" name="salarygrade">
    </div>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
