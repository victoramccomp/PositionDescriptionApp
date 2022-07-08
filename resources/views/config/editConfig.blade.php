@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Parâmetros e Configurações do Sistema</h2>
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

{{-- list --}}
<dl class="dl js-toggle">

    <dt class="toggle" data-toggle="accordionPositionInterest">
        <span>Parâmetros de Demonstração de Interesse</span> 
    </dt>
    <dd id="accordionPositionInterest">
        <div>
            <form method="post" action="{{ route( 'updateConfig' ) }}">

                @csrf

                <input
                    type="hidden"
                    name="id"
                    value="{{ $configPositionInterest->id }}">

                <div class="d-flex w-100">
                    <div>
                        <p class="m-0">Ao ativar esta opção, a funcionalidade de Demonstração de Interesse ficará ativa.</p>
                    </div>
                    <div class="d-flex ml-auto">
                        <span class="mr-2">Inativado</span>
            
                        <input
                            id="is_activated"
                            type="checkbox"
                            name="is_activated"
                            class="switch mr-2"
                            {{ $configPositionInterest->is_activated === 1 ? 'checked' : '' }} >
            
                        <span>Ativado</span>
                    </div>
                </div>
            
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Política de Privacidade</span>
                    </div>
                    <textarea
                        class="form-control terms_and_privacy"
                        name="terms_and_privacy"
                        required
                    >{{ $configPositionInterest->terms_and_privacy }}</textarea>
                </div>
            
                <button class="btn btn-primary mt-3">Salvar</button>
            
            </form>
        </div>
    </dd>

</dl>


@endsection
