@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Formulário de Demonstração de Interesse</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'reportListPositionDescription' ) }}" class="btn btn-primary float-right">Voltar</a>
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

<div class="row mb-3">
    <div class="col-md-12">
        <h3>Posição de Interesse: <strong>{{ $positionDescription->position->description }}</strong></h2>
    </div>
</div>

<form method="post" action="{{ route( 'storePositionInterest' ) }}">
    @csrf
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Nome Completo</span>
        </div>
        <input type="text" class="form-control" name="name">
    </div>

    <input type="hidden" value="{{ $positionDescription->id }}" name="depId">

    {{-- tipo --}}
    @php
        $keyA = 'i' . uniqid();
        $keyB = 'i' . uniqid();
        $keyC = 'i' . uniqid();
    @endphp

    <div class="d-flex js-interest-type">
        <div class="mr-3">
          <input type="radio" id="cpf" value="cpf" name="documentType" data-id="{{ $keyA }}" checked><label for="cpf" class="ml-1">CPF</label>
        </div>
        <div class="mr-3">
          <input type="radio" id="registration" value="registration" data-id="{{ $keyB }}" name="documentType"><label for="registration" class="ml-1">Matrícula</label>
        </div>
        <div>
          <input type="radio" id="email" value="email" data-id="{{ $keyC }}" name="documentType"><label for="email" class="ml-1">E-mail</label>
        </div>
    </div>

    <div class="js-interest-group">
        {{-- cpf --}}
        <div id="{{ $keyA }}" class="input-group js-interest-field visible">
            <div class="input-group-prepend">
                <span class="input-group-text">CPF</span>
            </div>
            <input type="text" class="form-control mask-cpf" maxlength="14" name="cpf" placeholder="000.000.000-00" required>
        </div>
    
        {{-- matricula --}}
        <div id="{{ $keyB }}" class="input-group js-interest-field">
            <div class="input-group-prepend">
                <span class="input-group-text">Matrícula</span>
            </div>
            <input type="text" class="form-control" name="registration">
        </div>
    
        {{-- email --}}
        <div id="{{ $keyC }}" class="input-group js-interest-field">
            <div class="input-group-prepend">
                <span class="input-group-text">E-mail</span>
            </div>
            <input type="email" class="form-control" name="email">
        </div>
    </div>

    <div class="mt-5">
        <h3>Políticas de Privacidade</h3>
    </div>
    
    <div class="input-group mt-3">
        <textarea
            class="form-control terms_and_privacy"
            name="terms_and_privacy"
            required
            disabled
        >{{ $configPositionInterest->terms_and_privacy }}</textarea>
    </div>
    
    <p class="mt-5">Ao Salvar você concorda com a Política de Privacidade acima.</p>

    <button class="btn btn-primary mt-3">Salvar</button>

</form>

@endsection
