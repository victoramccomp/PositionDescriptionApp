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
    <div class="row">
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Perspectiva</label>
        </div>
        <label class="form-control">
          {{ $positionDescriptions->interviewed == "leader" ? "Líder" : "Colaborador" }}
        </label>
      </div>
    </div>

    {{-- Position options --}}
    <div class="row">
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Nome da Posição</label>
        </div>
        <label class="form-control">
          {{ $positionDescriptions->position->description }}
        </label>
      </div>
    </div>

    {{-- Home office options --}}
    <div class="row">
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Mobilidade</label>
        </div>
        <label class="form-control">
          @if ( $positionDescriptions->allowhomeoffice == 0 )
            Aplicável totalmente
          @elseif (  $positionDescriptions->allowhomeoffice == 1 )
            Aplicável parcialmente
          @else
            Não aplicável
          @endif
        </label>
      </div>
    </div>

    {{-- Mission options --}}
    <div class="row">
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Missão</label>
        </div>
        <label class="form-control">
          {{ $positionDescriptions->mission }}
        </label>
      </div>
    </div>

    {{-- experience time --}}
    <div class="row">
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Tempo de Mercado (anos)</label>
        </div>
        <label class="form-control">
          {{ $positionDescriptions->experience_time }}
        </label>
      </div>
    </div>

    {{-- leadership time --}}
    <div class="row">
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Tempo de Liderança (anos)</label>
        </div>
        <label class="form-control">
          {{ $positionDescriptions->leadership_time }}
        </label>
      </div>
    </div>

  </div>
    
  {{-- Graduação --}}
  @if ( count( $positionDescriptions->gradeCourses ) > 0 )
    <div class="container">
      
      {{-- title --}}
      <div class="row">
        <h2 class="mt-5 mb-3 col-md-12">Formação</h2>
      </div>

      {{-- graduation table --}}
      <table class="table tablegrades">
        <thead>
          <tr>
            <th scope="col">Curso</th>
            <th scope="col">Status</th>
            <th scope="col">Importância</th>
            <th scope="col">Grau</th>
            <th scope="col">Área</th>
          </tr>
        </thead>
        <tbody>
          @foreach ( $positionDescriptions->gradeCourses as $positionCourse )
          <tr>
            <td>{{ $positionCourse->description }}</td>
            <td>{{ $positionCourse->pivot->status == "ongoing" ? "Em andamento" : "Completo" }}</td>
            <td>{{ $positionCourse->pivot->requirement == "differential" ? "Diferencial (Recomendado)" : "Necessário (Obrigatório)" }}</td>
            <td>{{ $positionCourse->grade->description }}</td>
            <td>{{ $positionCourse->area->description }}</td>
          <tr>
          @endforeach
        </tbody>
      </table>

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
      <table class="table tablelanguages">
        <thead>
          <tr>
            <th scope="col">Idioma</th>
            <th scope="col">Habilidade Linguística</th>
            <th scope="col">Nível</th>
            <th scope="col">Importância</th>
          </tr>
        </thead>
        <tbody>
          @foreach ( $positionDescriptions->languages as $language )
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
              {{ $language->pivot->requirement == "differential" ? "Diferencial (Recomendado)" : "Necessário (Obrigatório)" }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

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
      <table class="table tablecompetences">
        <thead>
          <tr>
            <th scope="col">Tipo de requisito</th>
            <th scope="col">Requisito específico</th>
            <th scope="col">Nível</th>
            <th scope="col">Importância</th>
          </tr>
        </thead>
        <tbody>
          @foreach ( $positionDescriptions->competences as $competence )
          <tr>
            <td>{{ $competence->competenceType->description }}</td>
            <td>{{ $competence->description }}</td>
            <td>
              {{
                $positionDescriptions->competenceLevel
                  ->where("id", $competence->pivot->level)
                  ->first()->description
              }}
            </td>
            <td>{{ $competence->pivot->requirement == "differential" ?  "Diferencial (Recomendado)" : "Necessário (Obrigatório)"  }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

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
          <div class="input-group targetgroup pb-3">
            <div class="input-group-prepend">
              <label class="input-group-text">Objetivo</label>
            </div>
            <label class="form-control">
              {{ $target->description }}
            </label>
          </div>

          @php {{ $targetIdAux = $target->id; }} @endphp

        @endif

        {{-- activity wrapper --}}
        <div class="pl-3 pr-3">

          {{-- activity --}}
          <div class="input-group mb-3 activitygroup">
            <div class="input-group-prepend">
              <label class="input-group-text">Atividade</label>
            </div>
            <label class="d-flex form-control">
              <span class="classification__container">
                {{ $target->pivot->classification }}
              </span>
              <span>
                {{ $positionDescriptions->activities->where("id", $target->pivot->mainactivity_id)->first()->description }}
              </span>
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
