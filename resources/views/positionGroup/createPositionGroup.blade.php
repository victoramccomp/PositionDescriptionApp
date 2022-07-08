@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Adicionar Grupo da Posição</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'listPositionGroup' ) }}" class="btn btn-primary float-right">Voltar</a>
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

<form method="post" action="{{ route( 'storePositionGroup' ) }}">
    @csrf
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Descrição</span>
        </div>
        <input type="text" class="form-control" name="description">
    </div>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
