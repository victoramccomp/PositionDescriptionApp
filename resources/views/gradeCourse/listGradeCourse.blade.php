
@extends('layout')

@section('header')

@endsection

@section('content')

<div class="row mb-3">
    <div class="col-md-7">
        <h2>Listagem de Cursos</h2>
    </div>
    <div class="col-md-5">
        <a href="{{ route( 'createGradeCourse' ) }}" class="btn btn-primary float-right">Adicionar</a>
    </div>
</div>

@if ( !empty( $message ) )
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<v-filter
    :has-interviewed="false"
    :has-pagination="true"
    :request="{{ $request }}"
></v-filter>

<ul class="list-group mb-3">
    @foreach ( $gradeCourses as $gradeCourse )
        <li class="d-flex list-group-item">
            <div>{{ $gradeCourse->description }} ({{ $gradeCourse->area->description }} | {{ $gradeCourse->grade->description }})</div>
            <form class="ml-auto" method="get" action="{{ route('editGradeCourse', $gradeCourse->id) }}">
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
    {{ $gradeCourses->links() }}
</div>

@endsection
