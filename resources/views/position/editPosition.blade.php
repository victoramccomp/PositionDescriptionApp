@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-6">
        <h2>Editar Posição</h2>
    </div>
    <div class="col-md-3">
        <a href="{{ route( 'listPosition' ) }}" class="btn btn-primary float-right">Voltar</a>
    </div>
    <div class="col-md-3">
        <a href="{{ route( 'deletePosition', $position->id ) }}" class="btn btn-danger float-right">Deletar Posição</a>
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

<form method="post" action="{{ route( 'updatePosition' ) }}">
    @csrf

    <select class="custom-select mb-3" name="positiongroup">
        <option value="0" selected>Selecione o Grupo da Posição</option>
        @foreach ( $positionGroups as $positionGroup )
            <option
                value="{{ $positionGroup->id }}"
                {{ $position->position_group_id === $positionGroup->id ? 'selected' : '' }}
            >{{ $positionGroup->description }}</option>
        @endforeach
    </select>

    <select class="custom-select mb-3" name="directorate">
        <option value="0" selected>Selecione a Diretoria</option>
        @foreach ( $directorates as $directorate )
            <option
                value="{{ $directorate->id }}"
                {{ $position->directorate_id === $directorate->id ? 'selected' : '' }}
            >{{ $directorate->description }}</option>
        @endforeach
    </select>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Descrição</span>
        </div>
		<input type="text" class="form-control" name="description" value="{{ $position->description }}">
		<input type="hidden" name="id" value="{{ $position->id }}">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Código da posição</span>
        </div>
        <input type="text" class="form-control" name="code" value="{{ $position->code }}">
    </div>

    <div class="input-group" style="display: none;">
        <div class="input-group-prepend">
            <span class="input-group-text">Grade Salarial</span>
        </div>
        <input type="text" class="form-control" name="salarygrade" value="{{ $position->salary_grade }}">
    </div>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
