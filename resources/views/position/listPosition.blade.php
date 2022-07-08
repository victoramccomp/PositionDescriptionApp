
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Posições</h2>
    </div>
    <div class="col-md-2">
        <a href="{{ route( 'createPosition' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
    <div class="col-md-2">
        <a href="{{ route( 'exportXLSXPosition' ) }}" class="btn btn-primary float-right">Exportar XLSX</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-warning">
        {{ session('status') }}
    </div>
@endif

<v-filter
    :has-interviewed="false"
    :has-pagination="true"
    :request="{{ $request }}"
></v-filter>

<ul class="list-group mb-3">
        <li
            class="list-group-item"
            style="font-weight: bold">

            <div class="d-flex justify-content-between align-itens-center">
                <div class="col-4">Descrição</div>
                <div class="col-2">Grupo</div>
                <div class="col-2">Diretoria</div>
                <div class="col-2">Código</div>
                <div class="col-2">Ações</div>
            </div>

        </li>
    @foreach ( $positions as $position )
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-itens-center">

                <div class="col-4">
                    <div>{{ $position->description }}</div>
                </div>

                @if ( $position->positionGroup )
                    <div class="col-2">
                        <div>{{ $position->positionGroup['description'] }}</div>
                    </div>
                @else
                    <div class="col-2">
                        <div>-</div>
                    </div>
                @endif

                @if ( $position->directorate )
                    <div class="col-2">
                        <div>{{ $position->directorate['description'] }}</div>
                    </div>
                @else
                    <div class="col-2">
                        <div>-</div>
                    </div>
                @endif

                @if ( $position->code )
                    <div class="col-2">
                        <div>{{ $position->code }}</div>
                    </div>
                @else
                    <div class="col-2">
                        <div>-</div>
                    </div>
                @endif

                <div class="col-2">
                    <form class="ml-auto" method="get" action="{{ route('editPosition', $position->id) }}">
                        @csrf
                        <button class="btn btn-primary">
                            <i class="far fa-edit"></i>
                            <span>Editar</span>
                        </button>
                    </form>
                </div>
            </div>
        </li>
    @endforeach
</ul>

<div class="m-auto">
    {{ $positions->links() }}
</div>

@endsection
