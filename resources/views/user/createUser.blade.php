@extends('layout')

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Adicionar Usuário</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'listUser' ) }}" class="btn btn-primary float-right">Voltar</a>
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

<div class="row justify-content-center">
    <div class="col-md-8">
        <form method="POST" action="{{ route('storeUser') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Nome completo</label>

                <div class="col-md-6">
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                        autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                <div class="col-md-6">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                <div class="col-md-6">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="new-password"
                        required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar senha</label>

                <div class="col-md-6">
                    <input
                        id="password-confirm"
                        name="password_confirmation"
                        type="password"
                        class="form-control"
                        autocomplete="new-password"
                        required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Registrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
