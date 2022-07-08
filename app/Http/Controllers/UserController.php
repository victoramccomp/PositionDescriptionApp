<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    public function index( Request $request )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $users = User::when($request, function($query) use ($request) {
            // check date range
            if (
                $request->has('start') && ! empty( $request->input('start') )
                && $request->has('end') && ! empty( $request->input('end') )
            ) {
                $query = $query->whereBetween('created_at', [ $request->start, $request->end ]);
            }

            // check search
            if ( $request->has('search') && ! empty( $request->input('search') ) ) {
                $query = $query->where('name', 'LIKE', '%' . $request->search . '%');
            }
        })->orderBy('name', 'ASC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'user.listUser', [
            'users' => $users,
            'message' => $message,
            'request' => json_encode( array(
                'range' => array( 'start' => $request->start, 'end' => $request->end ),
                'search' => $request->search
            ), true),
        ] );
    }

    public function create()
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'user.createUser' );
    }

    public function edit( int $user_id )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $user = User::findOrFail( $user_id );

        return view( 'user.editUser', [ 'user' => $user ] );
    }

    public function store( UserFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $request->session()->flash('message', "Usuário adicionado com sucesso!");

        return redirect()->route('listUser');
    }

    public function update( UserFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $request->session()->flash('message', "$user->name atualizado com sucesso!");

        return redirect()->route('listUser');
    }

    public function checkRolePermission( string $role )
    {
        $screen = 'user';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else
            return false;
    }
}
