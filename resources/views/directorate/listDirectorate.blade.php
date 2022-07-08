
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Diretorias</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'createDirectorate' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<ul class="list-group mb-3">
    @foreach ( $directorates as $directorate )
        <li class="d-flex list-group-item">
            <div>{{ $directorate->description }}</div>
            <form class="ml-auto" method="get" action="{{ route('editDirectorate', $directorate->id) }}">
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
    {{ $directorates->links() }}
</div>

@endsection