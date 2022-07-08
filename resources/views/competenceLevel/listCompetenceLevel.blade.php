
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Níveis de Competências</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'createCompetenceLevel' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<ul class="list-group mb-3">
    @foreach ( $competence_levels as $competence_level )
        <li class="d-flex list-group-item">
            <div>{{ $competence_level->description }} ({{ $competence_level->competenceType->description }})</div>
            <form class="ml-auto" method="get" action="{{ route('editCompetenceLevel', $competence_level->id) }}">
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
    {{ $competence_levels->links() }}
</div>

@endsection