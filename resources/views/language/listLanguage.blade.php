
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Idiomas</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'createLanguage' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<ul class="list-group mb-3">
    @foreach ( $languages as $language )
        <li class="d-flex list-group-item">
            <div>{{ $language->description }}</div>
            <form class="ml-auto" method="get" action="{{ route('editLanguage', $language->id) }}">
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
    {{ $languages->links() }}
</div>

@endsection