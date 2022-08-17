@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Parâmetros e Configurações do Sistema</h2 >
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
        <div>
            <form method="post" action="{{ route( 'updateConfig' ) }}">

                @csrf

                <input
                    type="hidden"
                    name="id"
                    value="{{ $configPositionInterest->id }}">

                <input
                    type="hidden"
                    name="config_hide_target_classification_id"
                    value="{{ $configHideTargetClassification->id }}">    

                <input
                    type="hidden"
                    name="config_guidelines_id"
                    value="{{ $configPositionGuidelines->id }}">    

                
                <input
                    type="hidden"
                    name="config_hide_target_activity_id"
                    value="{{ $configHideTargetActivity->id }}">    

                <hr>
                <h3>Demonstração de Interesse</h3>
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


                <hr>
                <h3>Diretrizes da Posição</h3>
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Texto das Diretrizes da Posição</span>
                    </div>
                    <textarea
                        class="form-control guidelines"
                        name="guidelines"
                        required
                    >{{ $configPositionGuidelines->guidelines }}</textarea>
                </div>


                <hr>
                <h3>Classificação das Atividades</h3>
                <div class="d-flex w-100">
                    <div>
                        <p class="m-0">Ao ativar esta opção, ocultará o campo de Classificação das Atividades no Relatório de Descrição de Posição</p>
                    </div>
                    <div class="d-flex ml-auto">
                        <span class="mr-2">Inativado</span>
            
                        <input
                            id="is_hidden"
                            type="checkbox"
                            name="is_hidden"
                            class="switch mr-2"
                            {{ $configHideTargetClassification->is_hidden === 1 ? 'checked' : '' }} >
            
                        <span>Ativado</span>
                    </div>
                </div>

                <hr>
                <h3>Ocultar Objetivos e Atividades</h3>
                <div class="d-flex w-100">
                    <div>
                        <p class="m-0">Ao ativar esta opção, os Objetivos e Atividades ficarão ocultos do Relatório de Descrição de Posição</p>
                    </div>
                    <div class="d-flex ml-auto">
                        <span class="mr-2">Inativado</span>
            
                        <input
                            id="is_hidden_activity"
                            type="checkbox"
                            name="is_hidden_activity"
                            class="switch mr-2"
                            {{ $configHideTargetActivity->is_hidden === 1 ? 'checked' : '' }} >
            
                        <span>Ativado</span>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Salvar</button>
            
            </form>
        </div>
@endsection
