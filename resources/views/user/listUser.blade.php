
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Usuários</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'createUser' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<v-filter
    :has-interviewed="false"
    :has-pagination="true"
    :request="{{ $request }}"
></v-filter>

<ul class="list-group mb-3">
    @foreach ( $users as $user )
        <li class="d-flex list-group-item">
            <div>{{ $user->name }}</div>
            <form class="ml-auto" method="get" action="{{ route('editUser', $user->id) }}">
                @csrf
                <button class="btn btn-primary">
                    <i class="far fa-edit"></i>
                    <span>Editar</span>
                </button>
            </form>
        </li>
    @endforeach
</ul>

<div class="m-auto">
    {{ $users->links() }}
</div>

@endsection
