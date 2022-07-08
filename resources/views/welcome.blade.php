@extends('layout')

@section('content')
    <div class="content">
        @auth
            <p>Bem vindo! Você está conectado.</p>
            <p>Use o menu superior para acessar as listagens que deseja</p>
        @else
            <p>Olá! Antes de prosseguir, você precisa fazer login</p>
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        @endauth

        <div class="mb-3" style="position:absolute;bottom:0;left:0;right:0">
            Powered by Thutor
        </div>
    </div>
@endsection