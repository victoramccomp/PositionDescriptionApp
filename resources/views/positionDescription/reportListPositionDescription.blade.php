
@extends('layout')

@section('header')

@endsection

@section('content')

<v-title title='Relatório de Descrições de Posição'></v-title>

@if ( !empty( $message ) )
<div class="alert alert-success">
    {{ $message }}
</div>
@endif

@auth
    {{-- vue filter WITHOUT default values--}}
    <v-filter
        :has-interviewed="true"
        :has-pagination="true"
        :directorates="{{ $directorates }}"
        :position-groups="{{ $positionGroups }}"
        :request="{{ $request }}"
    ></v-filter>
@else
    {{-- vue filter WITH default values--}}
    <v-filter
        :has-interviewed="true"
        :has-pagination="true"
        :directorates="{{ $directorates }}"
        :position-groups="{{ $positionGroups }}"
        :request="{{ $request }}"
        :default-params="{ interviewed: 'leader' }"
        :hidden="[ 'interviewed' ]"
    ></v-filter>
@endauth

{{-- list --}}
<dl class="dl js-toggle">

    @foreach ( $positionDescriptions as $positionDescription )
    <dt class="toggle" data-toggle="dep{{ $positionDescription->id }}">
        <span style="margin-right: 15px;">{{ $positionDescription->position->description }}</span>
        @auth
        <small>
            {{ $positionDescription->interviewed == "leader" ? 'Líder' : 'Colaborador' }}
        </small>
        @endauth
    </dt>
    <dd id="dep{{ $positionDescription->id }}">
        <div>
            @auth
            <div class="mb-4 mr-5">
                {{-- Export --}}
                <a
                    class="col-auto btn btn-primary mr-3"
                    href="{{ route('getPositionDescription', $positionDescription->id) }}"
                >Visualizar para impressão</a>

                {{-- Position Interest --}}
                @if ( $positionDescription->interviewed == "leader" && $configPositionInterest->is_activated )
                    <a
                        class="col-auto btn btn-primary mr-3"
                        href="{{ route('createPositionInterest', $positionDescription->id) }}"
                    >Demonstrar Interesse</a>
                @endif
            </div>
            @endauth
            {{-- Directorate & Position Group --}}
            <div class="d-flex align-itens-center">
                @if ( $positionDescription->position->directorate )
                    <div class="pr-3">
                        <strong class="font-weight-bold">Diretoria</strong>
                        <p>{{ $positionDescription->position->directorate['description'] }}</p>
                    </div>
                @endif

                @if ( $positionDescription->position->positionGroup )
                    <div>
                        <strong class="font-weight-bold">Grupo da Posição</strong>
                        <p>{{ $positionDescription->position->positionGroup['description'] }}</p>
                    </div>
                @endif
            </div>

            {{-- Mission --}}
            <div>
                <strong class="font-weight-bold">Missão da Posição</strong>
                <p>{{ $positionDescription->mission }}</p>
            </div>

            {{-- Position Info --}}
            <div class="d-flex align-itens-center">
                <strong class="font-weight-bold pr-3">Tempo de Liderança (em anos):</strong>
                <span class="d-block text-left" style="width: 80px;">{{ $positionDescription->leadership_time }}</span>

                <strong class="font-weight-bold pr-3">Tempo de Experiência (em anos):</strong>
                <span class="d-block text-left" style="width: 80px;">{{ $positionDescription->experience_time }}</span>

                <strong class="font-weight-bold pr-3">Mobilidade:</strong>
                <span class="d-block text-left" style="width: 140px;">

                    @if($positionDescription->allowhomeoffice == 0)
                        Aplicável totalmente
                    @elseif($positionDescription->allowhomeoffice == 1)
                        Aplicável parcialmente
                    @else
                        Não aplicável
                    @endif
                </span>
            </div>

            {{-- Courses --}}
            @if (count($positionDescription->gradeCourses) > 0)
            <div style="margin-top: 10px;">
                <strong class="font-weight-bold">Formação</strong>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Grau</th>
                            <th scope="col">Área</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Status</th>
                            <th scope="col">Importância</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positionDescription->gradeCourses as $course)
                            <tr>
                                <td>{{ $course->grade->description }}</th>
                                <td>{{ $course->area->description }}</td>
                                <td>{{ $course->description }}</td>
                                <td>
                                    @if($course->pivot->status == "ongoing")
                                        Em Andamento
                                    @else
                                        Completo
                                    @endif
                                </td>
                                <td>
                                    @if($course->pivot->requirement == "differential")
                                        Diferencial (Recomendado)
                                    @else
                                        Necessário (Obrigatório)
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Languages --}}
            @if (count($positionDescription->languages) > 0)
            <div style="margin-top: 10px;">
                <strong class="font-weight-bold">Idiomas</strong>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Idioma</th>
                            <th scope="col">Habilidade Linguística</th>
                            <th scope="col">Nível</th>
                            <th scope="col">Importância</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positionDescription->languages as $language)
                            <tr>
                                <td>{{ $language->description }}</td>
                                <td>
                                    @if($language->pivot->skill == "talk")
                                        Fala
                                    @elseif($language->pivot->skill == "writing")
                                        Escrita
                                    @elseif($language->pivot->skill == "reading")
                                        Leitura
                                    @else
                                        Escuta
                                    @endif
                                </td>
                                <td>
                                    @if($language->pivot->level == "basic")
                                        Básico
                                    @elseif($language->pivot->level == "advanced")
                                        Avançado
                                    @elseif($language->pivot->level == "fluent")
                                        Fluente
                                    @else
                                        Intermediário
                                    @endif
                                </td>
                                <td>
                                    @if($language->pivot->requirement == "differential")
                                        Diferencial (Recomendado)
                                    @else
                                        Necessário (Obrigatório)
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Competences --}}
            @if (count($positionDescription->competences) > 0)
            <div style="margin-top: 10px;">
                <strong class="font-weight-bold">Competências e Requisitos Específicos</strong>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tipo de Requisito</th>
                            <th scope="col">Requisito Específico</th>
                            <th scope="col">Nível</th>
                            <th scope="col">Importância</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($positionDescription->DEPCompetence as $competence)
                            <tr>
                                <td>{{ $competence->type_description }}</td>
                                <td>{{ $competence->competence_description }}</td>
                                <td>{{ $competence->level_description }}</td>
                                <td>
                                    @if($competence->requirement == "differential")
                                        Diferencial (Recomendado)
                                    @else
                                        Necessário (Obrigatório)
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Target & Activities --}}
            @if (count($positionDescription->targets) > 0 && !$configHideTargetActivity->is_hidden)
            <div style="margin-top: 10px;">
                <strong class="font-weight-bold">Objetivos e Atividades</strong>
                @php {{ $targetIdAux = 0; }} @endphp
                <div style="margin-top: 10px;">

                @foreach ($positionDescription->targets as $target)
                    
                    @if ($targetIdAux != $target->id)
                        <p class="mb-10"><strong class="font-weight-bold">Objetivo: {{ $target->description }}</strong></p>

                        @php {{ $targetIdAux = $target->id; }} @endphp
                    @endif

                    <p class="d-flex" style="margin-left:30px;align-items:flex-start;">
                        @if ( $configHideTargetClassification->is_hidden == 0 )
                            <span class="classification__container">
                                {{ $target->pivot->classification }}
                            </span>
                        @endif
                        <span>
                            <strong class="font-weight-bold">
                                {{ $target->pivot->activity_order }} - 
                            </strong>
                            {{ $positionDescription->activities->where('id', $target->pivot->mainactivity_id)->first() ? $positionDescription->activities->where('id', $target->pivot->mainactivity_id)->first()->description : "" }}
                        </span>
                    </p>

                @endforeach

                </div>
            </div>
            @endif

            {{-- Restrictions --}}
            @if ($positionDescription->restrictions != '')
            <div style="margin-top: 10px">
                <strong class="font-weight-bold">Diretrizes da Posição</strong>
                <p class="restrictions__container" style="margin-top: 10px">{{ $positionDescription->restrictions }}</p>
            </div>
            @endif

            {{-- Comments --}}

            @if ($positionDescription->interviewer_comments != '')
            <div style="margin-top: 10px">
                <strong class="font-weight-bold">Comentários</strong>
                <p class="restrictions__container" style="margin-top: 10px">{{ $positionDescription->interviewer_comments }}</p>
            </div>
            @endif

            {{-- Guidelines --}}
            @if ($configPositionGuidelines->guidelines != '')
            <div style="margin-top: 10px">
                <strong class="font-weight-bold">Diretrizes Gerais da Posição</strong>
                <p class="restrictions__container" style="margin-top: 10px">{{ $configPositionGuidelines->guidelines }}</p>
            </div>
            @endif
        </div>
    </dd>
    @endforeach

</dl>

{{-- pagination --}}
<div class="m-auto">
    {{ $positionDescriptions->links() }}
</div>

@endsection




