
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Graus</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'createGrade' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<ul class="list-group mb-3">
    @foreach ( $grades as $grade )
        <li class="d-flex list-group-item">
            <div>{{ $grade->description }}</div>
            <form class="ml-auto" method="get" action="{{ route('editGrade', $grade->id) }}">
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
    {{ $grades->links() }}
</div>

@endsection