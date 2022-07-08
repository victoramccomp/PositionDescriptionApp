
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-8">
        <h2>Listagem de Descrições de Posição</h2>
    </div>
    <div class="col-md-2">
        <a href="{{ route( 'createPositionDescription' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
    <div class="col-md-2">
        <a href="{{ route( 'exportXLSXPositionDescription' ) }}" class="btn btn-primary float-right">Exportar XLSX</a>
    </div>
</div>

@if ( !empty( $message ) )
<div class="alert alert-success">
    {{ $message }}
</div>
@endif

<v-filter
    :has-interviewed="true"
    :has-pagination="true"
    :request="{{ $request }}"
></v-filter>

<ul class="list-group">
    <li
        class="list-group-item"
        style="font-weight: bold">

        <div class="d-flex justify-content-between align-itens-center">
            <div class="col-1">Cóidigo da Posição</div>
            <div class="col-3">Posição</div>
            <div class="col-1">Perspectiva</div>
            <div class="col-2">Último Editor</div>
            <div class="col-2">Última Mudança</div>
            <div class="col-3">Ações</div>
        </div>

    </li>
    @foreach ( $positionDescriptions as $positionDescription )

    <li class="list-group-item {{ $positionDescription->is_activated ? "" : "bg-danger text-white" }}">
        <div class="d-flex justify-content-between align-itens-center">

            <div class="col-1">
                @if ( $positionDescription->position->code )
                    {{ $positionDescription->position->code }}
                @else
                    -
                @endif
            </div>

            <div class="col-3">
                {{ $positionDescription->position->description }}
            </div>

            <div class="col-1">
                {{ $positionDescription->interviewed == "leader" ? 'Líder' : 'Colaborador' }}
            </div>

            <div class="col-2">
                {{ $positionDescription->user->name }}
            </div>

            <div class="col-2">
                {{ date('d-m-Y', strtotime($positionDescription->updated_at)) }}
            </div>

            <div class="col-3">
                <a class="col-auto btn btn-primary" href="{{ route('editPositionDescription', $positionDescription->id) }}">Editar</a>

                @if( $positionDescription->interviewed !== "leader" )
                    <a class="col-auto btn btn-primary" href="{{ route('validatePositionDescription', $positionDescription->id) }}">Validar</a>
                @endif

                <a class="col-auto btn btn-primary" href="{{ route('getPositionDescription', $positionDescription->id) }}">Visualizar</a>
            </div>

        </div>
    </li>
    @endforeach
</ul>

<div class="mt-5">
    {{ $positionDescriptions->links() }}
</div>

@endsection
