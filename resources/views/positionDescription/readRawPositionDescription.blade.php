@extends("layout")

@section("header")

@endsection

@section("content")

{{-- form dep --}}
<div class="read_position_form">
  @csrf
  
  {{-- Informações da Posição --}}
  <div class="container">
    
    {{-- title --}}
    <div class="row">
      <h2 class="mt-5 mb-3 col-md-12">Informações da Posição</h2>
    </div>
    {{-- Leader / Collaborator options --}}
    <label>Perspectiva: {{ $positionDescriptions->interviewed == "leader" ? "Líder" : "Colaborador" }}</label><br>
    <label>Nome da Posição: {{ $positionDescriptions->position->description }}</label><br>
    <label>
      @if ( $positionDescriptions->allowhomeoffice == 0 )
        Mobilidade: Aplicável totalmente
      @elseif (  $positionDescriptions->allowhomeoffice == 1 )
        Mobilidade: Aplicável parcialmente
      @else
        Mobilidade: Não aplicável
      @endif
    </label><br>
    <label>Missão: {{ $positionDescriptions->mission }}</label><br>
    <label>Tempo de Mercado (anos): {{ $positionDescriptions->experience_time }}</label><br>
    <label>Tempo de Liderança (anos) {{ $positionDescriptions->leadership_time }}</label><br>
  </div>
    
  {{-- Graduação --}}
  @if ( count( $positionDescriptions->gradeCourses ) > 0 )
    <div class="container">
      
      {{-- title --}}
      <div class="row">
        <h2 class="mt-5 mb-3 col-md-12">Formação</h2>
      </div>
      {{-- graduation table --}}
      @foreach ( $positionDescriptions->gradeCourses as $positionCourse )

        <label>Curso: {{ $positionCourse->description }}</label><br>
        <label>Grau: {{ $positionCourse->grade->description }}</label><br>
        <label>Área: {{ $positionCourse->area->description }}</label><br>
        <label>Status: {{ $positionCourse->pivot->status == "ongoing" ? "Em andamento" : "Completo" }}</label><br>
        <label>Importância: {{ $positionCourse->pivot->requirement == "differential" ? "Diferencial (Recomendado)" : "Necessário (Obrigatório)" }}</label><br>
        <br>
        <br>
      @endforeach

    </div>
  @endif

  {{-- Idiomas --}}
  @if ( count( $positionDescriptions->languages ) > 0 )
    <div class="container">

      {{-- title --}}
      <div class="row">
        <h2 class="mt-5 mb-3 col-md-12">Idiomas</h2>
      </div>
      {{-- language table --}}
      @foreach ( $positionDescriptions->languages as $language )
        <label>Idioma: {{ $language->description }}</label><br>
        <label>
          @if($language->pivot->skill == "talk")
            Habilidade Linguística: Fala
          @elseif($language->pivot->skill == "writing")
            Habilidade Linguística: Escrita
          @elseif($language->pivot->skill == "reading")
            Habilidade Linguística: Leitura
          @else
            Habilidade Linguística: Escuta
          @endif
        </label><br>
        <label>
          @if($language->pivot->level == "basic")
            Nível: Básico
          @elseif($language->pivot->level == "advanced")
            Nível: Avançado
          @elseif($language->pivot->level == "fluent")
            Nível: Fluente
          @else
            Nível: Intermediário
          @endif
        </label><br>
        <label>
          Importência: {{ $language->pivot->requirement == "differential" ? "Diferencial (Recomendado)" : "Necessário (Obrigatório)" }}
        </label><br>
        <br>
        <br>
      @endforeach

    </div>
  @endif

  {{-- Habilidades --}}
  @if ( count( $positionDescriptions->competences ) > 0 )
    <div class="container">
      
      {{-- title --}}
      <div class="row">
        <h2 class="mt-5 mb-3 col-md-12">Competências e Requisitos Específicos</h2>
      </div>

      {{-- competence table --}}
      @foreach ( $positionDescriptions->competences as $competence )
  
        <label>Tipo de requisito: {{ $competence->competenceType->description }}</label><br>
        <label>Requisito específico: {{ $competence->description }}</label><br>
        <label>Nível: 
          {{
            $positionDescriptions->competenceLevel
              ->where("id", $competence->pivot->level)
              ->first()->description
          }}
        </label><br>
        <label>Importância: {{ $competence->pivot->requirement == "differential" ?  "Diferencial (Recomendado)" : "Necessário (Obrigatório)"  }}</label><br>
        <br>
        <br>  
      @endforeach
    </div>
  @endif
  
  {{-- Principais Objetivos e Atividades --}}
  @if ( count( $positionDescriptions->targets ) > 0 )
    <div class="container">
    
    {{-- title --}}
    <div class="row">
      <h2 class="mt-5 mb-3 col-md-12">Principais Objetivos e Atividades</h2>
    </div>

    @php {{ $targetIdAux = 0; }} @endphp

    @foreach  ( $positionDescriptions->targets as $target )
      <div class="containertarget mb-3">

        @if ( $targetIdAux != $target->id )

          {{-- target --}}
          <div>
            <label>
              Objetivo: {{ $target->description }}
            </label>
          </div>
          <br>

          @php {{ $targetIdAux = $target->id; }} @endphp

        @endif

        {{-- activity wrapper --}}
        <div class="pl-3 pr-3">

          {{-- activity --}}
          <div>
            <label>
              Atividade: {{ $positionDescriptions->activities->where('id', $target->pivot->mainactivity_id)->first() ? $positionDescriptions->activities->where('id', $target->pivot->mainactivity_id)->first()->description : "" }}
            </label>
            <br>
            <label>
                Classificação: {{ $target->pivot->classification }}
            </label>
          </div>

        </div>

      </div>
    @endforeach

    </div>
  @endif

  {{-- Diretrizes da Posição --}}
  @if ( $positionDescriptions->restrictions != '' )
    <div class="print__break-line"></div>

    {{-- Restrictions --}}
    <div class="container">
    
      {{-- title --}}
      <div class="row">
        <h2 class="mt-5 mb-3 col-md-12">Diretrizes da Posição</h2>
      </div>

      <div class="containertarget mb-3 restrictions__container">{{ $positionDescriptions->restrictions }}</div>

    </div>

    {{-- Sign --}}
    <div class="sign__container container">
    
      <p style="margin-bottom: 40px">
        Ciente
        <br>_________________________________________
      </p>

      <p>
        Nome:___________________________________
      </p>

      <p style="margin-bottom: 40px">
        CPF:____________________________________
      </p>

      <p>
        Data: ______________________________________________________, _____ de _____________________ de _______
      </p>

    </div>
  @endif

  <v-export-pdf title="Exportar"></v-export-pdf>

</div>

@endsection
