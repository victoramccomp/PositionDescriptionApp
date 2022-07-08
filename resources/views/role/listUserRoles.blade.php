@extends('layout')

@section('content')

<div class="row mb-3">
	<div class="col-md-8">
		<h2>Listagem de Usuários</h2>
	</div>
</div>

@if ( !empty( $message ) )
<div class="alert alert-success">
    {{ $message }}
</div>
@endif

<ul class="list-group">
	@foreach ( $users->sortBy('name') as $user )

    <li class="list-group-item"> 
        <div class="d-flex justify-content-between align-itens-center">

            <div class="col-auto">
                {{ $user->name }} 
            </div>

			<a
				class="col-2 btn btn-primary"
				href="{{ route("editUserRoles", $user->id) }}"
			>Alterar Permissões</a>

        </div>
	</li>
	
    @endforeach
</ul>

<div class="m-auto">
    {{ $users->links() }}
</div>


@endsection
