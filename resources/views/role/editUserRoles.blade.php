@extends('layout')

@section('content')

@csrf

<v-roles
	user="{{ $user }}"
	roles="{{ $roles }}"
	user-roles="{{ $userRoles }}"
	message="{{ empty( $message ) ? '' : $message }}"
	update-path="{{ route("updateUserRoles") }}">

@endsection
