@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Editar Diretoria</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'listDirectorate' ) }}" class="btn btn-primary float-right">Voltar</a>
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

<form method="post" action="{{ route( 'updateDirectorate' ) }}">
    @csrf
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Descrição</span>
        </div>
		<input type="text" class="form-control" name="description" value="{{ $directorate->description }}">
		<input type="hidden" name="id" value="{{ $directorate->id }}">
    </div>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
