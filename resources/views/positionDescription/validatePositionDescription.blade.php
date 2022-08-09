@extends('layout')

@section('header')

@endsection

@section('content')

{{-- loading --}}
<div class="canvas">
  <div
    class="spinner-grow text-info"
    role="status">

    <span class="sr-only">Loading...</span>

  </div>
</div>

{{-- form dep --}}
<form id="formdep">
  @csrf
  
  {{-- Informações da Posição --}}
  <div class="container">
    
    {{-- title --}}
    <div class="row">
      <h2 class="mt-5 mb-3 col-md-12">Informações da Posição</h2>
    </div>

    {{-- Leader / Collaborator options --}}
    <div class="row">

      {{-- leader --}}
      <div class="input-group mb-3 col-md-6">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input id="interviewed-leader" name="interviewed" type="radio" value="leader" checked required>
          </div>
        </div>
        <label class="form-control" for="interviewed-leader">Líder</label>
      </div>
      
      {{-- collaborator --}}
      <div class="input-group mb-3 col-md-6">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input id="interviewed-colaborator" name="interviewed" type="radio" value="colaborator" required>
          </div>
        </div>
        <label class="form-control" for="interviewed-colaborator">Colaborador</label>
      </div>
      
    </div>

    {{-- Position options --}}
    <div class="row">

      {{-- position name --}}
      <div class="input-group mb-3 autocomplete col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Nome da Posição</label>
        </div>
        <input type="hidden" name="position-id" class="position-id" value="-1">
        <input id="position" autocomplete="off" class="position form-control" type="text" name="position" data-type="position" required>
      </div>

    </div>

    {{-- Home office options --}}
    <div class="row">

      <div class="col-md-12">
        <label>Mobilidade</label>
      </div>

      {{-- allow home office --}}
      <div class="input-group mb-3 col-md-4">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input id="yes-allowhomeoffice" class="allowhomeoffice" name="allowhomeoffice" type="radio" value="0">
          </div>
        </div>
        <label class="form-control" for="yes-allowhomeoffice">Aplicável totalmente</label>
      </div>

      {{-- half allowed home office --}}
      <div class="input-group mb-3 col-md-4">
        <div class="input-group-prepend">
          <div class="input-group-text">
          <input id="maybe-allowhomeoffice" class="allowhomeoffice" name="allowhomeoffice" type="radio" value="1">
          </div>
        </div>
        <label class="form-control" for="maybe-allowhomeoffice">Aplicável parcialmente</label>
      </div>

      {{-- not allowed home office --}}
      <div class="input-group mb-3 col-md-4">
        <div class="input-group-prepend">
          <div class="input-group-text">
          <input id="no-allowhomeoffice" class="allowhomeoffice" name="allowhomeoffice" type="radio" value="2">
          </div>
        </div>
        <label class="form-control" for="no-allowhomeoffice">Não aplicável</label>
      </div>

    </div>

    {{-- Mission options --}}
    <div class="row">

      <div class="col-md-12">
        <label>Missão</label>
      </div>

      {{-- mission textarea --}}
      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <span class="input-group-text">Missão na Posição</span>
        </div>
        <textarea class="form-control mission" name="mission" required></textarea>
      </div>

    </div>

    {{-- Professional experience --}}
    <div class="row">

      <div class="col-md-12">
        <label>Experiência</label>
      </div>

      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Tempo de Mercado (anos)</label>
        </div>
        <input type="number" min="0" class="form-control experiencetime" name="experiencetime" value="0" required>
      </div>

    </div>

    {{-- leadership experience --}}
    <div class="row">

      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <label class="input-group-text">Tempo de Liderança (anos)</label>
        </div>
        <input type="number" min="0" class="form-control leadershiptime" name="leadershiptime" value="0" required>
      </div>

    </div>

  </div>
    
  {{-- Graduação --}}
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
          <th scope="col">Grau</th>
          <th scope="col">Área</th>
          <th scope="col">Status</th>
          <th scope="col">Importância</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        {{-- AQUI O JS ADICIONA LINHAS DE CURSOS INSERIDOS --}}
      </tbody>
    </table>

    {{-- grade wrappper --}}
    <div class="wrapperGrade">

      {{-- grade filters --}}
      <div class="row">

        {{-- grade option --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Grau</label>
          </div>
          <select class="custom-select grade" id="grade" name="grade" data-key="grade_id">
            <option value="" selected>Selecione para filtrar o Curso</option>
            @foreach ( $grades as $grade )
              <option value="{{ $grade->id }}">{{ $grade->description }}</option>
            @endforeach
          </select>
        </div>

        {{-- area option --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
              <label class="input-group-text">Área</label>
          </div>
          <select class="custom-select area" id="area" name="area" data-key="area_id">
              <option value="" selected>Selecione para filtrar o Curso</option>
              @foreach ( $areas as $area )
                  <option value="{{ $area->id }}">{{ $area->description }}</option>
              @endforeach
          </select>
        </div>

      </div>

      {{-- course option --}}
      <div class="row">

        <div class="input-group mb-3 col-md-12">
          <div class="input-group-prepend">
            <label class="input-group-text">Curso (Se não aplicável preencha com "Qualquer curso")</label>
          </div>
          <input type="hidden" name="gradecourse-id" class="gradecourse-id" value="-1">
          <input autocomplete="off" class="gradecourse form-control" type="text" name="gradecourse">
        </div>

      </div>

      {{-- status / requirement options  --}}
      <div class="row">

        {{-- status --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Status do Grau</label>
          </div>
          <select class="custom-select" id="gradestatus" name="gradestatus">
            <option value="ongoing">Em Andamento</option>
            <option value="completed">Completo</option>
          </select>
        </div>

        {{-- requirement --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Importância do Grau</label>
          </div>
          <select class="custom-select" id="graderequirement" name="graderequirement">
            <option value="required">Necessário (Obrigatório)</option>
            <option value="differential">Diferencial (Recomendado)</option>
          </select>
        </div>

      </div>

    </div>

    <button class="btn btn-primary addgradecourse">Adicionar Curso</button>

  </div>

  {{-- Idiomas --}}
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
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        {{-- AQUI O JS ADICIONA LINHAS DE IDIOMAS INSERIDOS --}}
      </tbody>
    </table>

    {{-- language wrapper --}}
    <div class="wrapperlanguage">
      
      {{-- language option --}}
      <div class="row">

        <div class="input-group mb-3 col-md-12">
          <div class="input-group-prepend">
            <label class="input-group-text">Idioma</label>
          </div>
          <select class="custom-select grade" id="language" name="language" data-key="language_id">
            <option value="0" selected>Selecione o idioma</option>
            @foreach ( $languages as $language )
              <option value="{{ $language->id }}">{{ $language->description }}</option>
            @endforeach
          </select>
        </div>

      </div>

      {{-- skill / status options --}}
      <div class="row">

        {{-- skill --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Habilidade Linguística</label>
          </div>
          <select class="custom-select" id="languageskill" name="languageskill">
            <option value="talk">Fala</option>
            <option value="listening">Escuta</option>
            <option value="writing">Escrita</option>
            <option value="reading">Leitura</option>
          </select>
        </div>

        {{-- status --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Nível do Idioma</label>
          </div>
          <select class="custom-select" id="languagestatus" name="languagestatus">
            <option value="basic">Básico</option>
            <option value="intermediate">Intermediário</option>
            <option value="advanced">Avançado</option>
            <option value="fluent">Fluente</option>
          </select>
        </div>

      </div>

      {{-- requirement --}}
      <div class="row">

        <div class="input-group mb-3 col-md-12">
          <div class="input-group-prepend">
            <label class="input-group-text">Importância do Idioma</label>
          </div>
          <select class="custom-select" id="languagerequirement" name="languagerequirement">
            <option value="required">Necessário (Obrigatório)</option>
            <option value="differential">Diferencial (Recomendado)</option>
          </select>
        </div>

      </div>

    </div>

    <button class="btn btn-primary addlanguage">Adicionar Idioma</button>

  </div>

  {{-- Habilidades --}}
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
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        {{-- AQUI O JS ADICIONA LINHAS DE IDIOMAS INSERIDOS --}}
      </tbody>
    </table>

    {{-- competence wrapper --}}
    <div class="wrappercompetence">
      
      {{-- type --}}
      <div class="row">

        <div class="input-group mb-3 col-md-12">
          <div class="input-group-prepend">
            <label class="input-group-text">Tipo de requisito</label>
          </div>
          <select class="custom-select competencetype" id="competencetype" name="competencetype" data-key="competence_type_id">
            <option value="0" selected>Selecione para filtrar o requisito específico e seus níveis</option>
            @foreach ( $competenceTypes as $competenceType )
              <option value="{{ $competenceType->id }}">{{ $competenceType->description }}</option>
            @endforeach
          </select>
        </div>

      </div>

      {{-- name --}}
      <div class="row">

        <div class="input-group mb-3 col-md-12">
          <div class="input-group-prepend">
            <label class="input-group-text">Requisito específico</label>
          </div>
          <input type="hidden" name="competence-id" class="competence-id" value="-1">
          <input disabled autocomplete="off" class="competence form-control" type="text" name="competence" required>
        </div>

      </div>

      {{-- level / requirement options --}}
      <div class="row">

        {{-- level --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Nível</label>
          </div>
          <select disabled class="custom-select competencelevel" id="competencelevel" name="competencelevel" data-key="competencelevel_id">
            <option value="0" selected>Selecione o requisito específico</option>
            @foreach ( $competenceLevels as $competenceLevel )
              <option value="{{ $competenceLevel->id }}">{{ $competenceLevel->description }}</option>
            @endforeach
          </select>
        </div>

        {{-- requirement --}}
        <div class="input-group mb-3 col-md-6">
          <div class="input-group-prepend">
            <label class="input-group-text">Importância</label>
          </div>
          <select class="custom-select competencerequirement" id="competencerequirement" name="competencerequirement">
            <option value="required">Necessário (Obrigatório)</option>
            <option value="differential">Diferencial (Recomendado)</option>
          </select>
        </div>

      </div>

    </div>

    <button class="btn btn-primary addcompetence">Adicionar requisito específico</button>

  </div>
  
  {{-- Principais Objetivos e Atividades --}}
  <div class="container">

    {{-- title --}}
    <div class="row">
      <h2 class="mt-5 mb-3 col-md-12">Principais Objetivos e Atividades</h2>
    </div>

    {{-- target wrapper --}}
    <div class="wrappertarget">

      {{-- add target --}}
      <button class="btn btn-primary addtarget">Adicionar Objetivo</button>

    </div>

    {{-- target reference --}}
    <div class="containertarget mb-3 d-none">

      {{-- target --}}
      <div class="input-group targetgroup">
        <div class="input-group-prepend">
          <label class="input-group-text">Objetivo</label>
        </div>
        <input type="hidden" name="target-id" class="target-id" value="-1">
        <input autocomplete="off" class="target form-control" type="text" name="target" maxlength="200">
        <div class="input-group-append">
          <i class="btn btn-outline-danger far fa-trash-alt"></i>
        </div>

        {{-- Target Order --}}

        <div class="input-group mb-3 col-md-3">
          <div class="input-group-prepend">
            <label class="input-group-text">Ordem do Objetivo</label>
          </div>
          <input type="number" min="0" class="form-control targetorder" name="targetorder" value="0" required>
        </div>
      </div>

      {{-- activity wrapper --}}
      <div class="wrapperactivity pl-3 pr-3 pt-3">

        {{-- add activity --}}
        <button class="btn btn-primary mb-3 addactivity">Adicionar Atividade</button>

      </div>

    </div>
  
    {{-- activity reference --}}
    <div class="containeractivity d-none">

      {{-- activity --}}
      <div class="input-group mb-3 activitygroup">
        <div class="input-group-prepend">
          <label class="input-group-text">Atividade</label>
        </div>
        <input type="hidden" name="activity-id" class="activity-id" value="-1">
        <input autocomplete="off" class="activity form-control" type="text" name="activity">
        <div class="input-group-append">
          <i class="btn btn-outline-danger far fa-trash-alt"></i>
        </div>
      </div>

      {{-- classification --}}
      <div class="input-group mb-3 ml-3" style="width: 290px">
        <div class="input-group-prepend">
          <label class="input-group-text">Classificação</label>
        </div>
        <select name="classification" class="form-control">
          <option value="">Selecione uma opção</option>
          <option value="P">P</option>
          <option value="D">D</option>
          <option value="C">C</option>
          <option value="A">A</option>
        </select>
      </div>

      {{-- Activitie Order --}}
      <div class="input-group mb-3 col-md-3">
        <div class="input-group-prepend">
          <label class="input-group-text">Ordem da Atividade</label>
        </div>
        <input type="number" min="0" class="form-control activityorder" name="activityorder" value="0" required>
      </div>
    </div>

  </div>

  {{-- Comentários Adicionais --}}
  <div class="container">

    {{-- comments --}}
    <div class="row">

      <div class="input-group mb-3 mt-5 col-md-12">
        <div class="input-group-prepend">
          <span class="input-group-text">Comentários Adicionais</span>
        </div>
        <textarea class="form-control interviewercomments" name="interviewercomments"></textarea>
      </div>

      <div class="input-group mb-3 col-md-12">
        <div class="input-group-prepend">
          <span class="input-group-text">Diretrizes da Posição</span>
        </div>
        <textarea class="form-control restrictions" name="restrictions"></textarea>
      </div>

    </div>

  </div>

  {{-- form submit --}}
  <button type="submit" class="btn btn-success mb-5 mt-3 mr-auto ml-auto d-block">Enviar Descrição de Posição</button>
  
</form>

<div class="depformstorage"></div>

{{-- write datas --}}
<v-write request="{{ $positions }}" name="positions"></v-write>
<v-write request="{{ $gradeCourses }}" name="gradeCourses"></v-write>
<v-write request="{{ $competences }}" name="competences"></v-write>
<v-write request="{{ $competenceLevels }}" name="competenceLevels"></v-write>
<v-write request="{{ $targets }}" name="targets"></v-write>
<v-write request="{{ $activities }}" name="activities"></v-write>
<v-write request="{{ $directorates }}" name="directorates"></v-write>
<v-write request="{{ $positionGroups }}" name="positionGroups"></v-write>

<v-write request="{{ $positionDescriptions }}" name="positionDescriptions"></v-write>
<v-write request="{{ $depGrades }}" name="depGrades"></v-write>
<v-write request="{{ $depLanguages }}" name="depLanguages"></v-write>
<v-write request="{{ $depCompetences }}" name="depCompetences"></v-write>
<v-write request="{{ $depMainTargets }}" name="depMainTargets"></v-write>

@endsection
