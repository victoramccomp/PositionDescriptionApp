@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Adicionar Competência</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'listCompetence' ) }}" class="btn btn-primary float-right">Voltar</a>
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

<form method="post" action="{{ route( 'storeCompetence' ) }}">
    @csrf

    <select class="custom-select mb-3" name="competence_type">
        <option value="0" selected>Selecione o Tipo de Competência</option>
        @foreach ( $competence_types as $competence_type )
            <option value="{{ $competence_type->id }}">{{ $competence_type->description }}</option>
        @endforeach
    </select>

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Descrição</span>
        </div>
        <input type="text" class="form-control" name="description">
    </div>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
