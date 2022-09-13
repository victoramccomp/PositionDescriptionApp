
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Interessados na Posição</h2>
    </div>
    
    <div class="col-md-2">
        <a href="{{ route( 'exportXLSXPositionInterest' ) }}" class="btn btn-primary float-right">Exportar XLSX</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<ul class="list-group mb-3">
    <li class="d-flex list-group-item list-group-item-primary">
        <div class="col-3">
            <div>Nome do Colaborador</div>
        </div>
            
        <div class="col-2">
            <div>Tipo de Documento</div>
        </div>
            
        <div class="col-2">
            <div>Cadastro</div>
        </div>
            
        <div class="col-3">
            <div>Posição de Interesse</div>
        </div>

        <div class="col-2">
            <div>Data do Interesse</div>
        </div>
    </li>
    @foreach ( $positionInterests as $positionInterest )
        <li class="d-flex list-group-item">

            <div class="col-3">
                <div>{{ $positionInterest->name }}</div>
            </div>
                
            <div class="col-2">
                @if( $positionInterest->document_type === 'registration' )
                    <div>Matrícula</div>
                @elseif ( $positionInterest->document_type === 'cpf' )
                    <div>CPF</div>
                @else
                    <div>E-mail</div>
                @endif
            </div>
                
            <div class="col-2">
                <div>{{ $positionInterest->document_info }}</div>
            </div>
                
            <div class="col-3">
                <div class="col-md-2">
                    <a href="{{ route('getPositionDescription', $positionInterest->positionDescription->id) }}">
                        {{ $positionInterest->positionDescription->position->description }}
                    </a>
                </div>
            </div>
            <div class="col-2">
                <div>{{ date('d-m-Y', strtotime($positionInterest->created_at)) }}</div>
            </div>
        </li>
    @endforeach
</ul>

<div class="m-auto">
    {{ $positionInterests->links() }}
</div>

@endsection