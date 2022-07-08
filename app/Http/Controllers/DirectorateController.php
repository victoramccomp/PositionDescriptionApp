<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Directorate;
use App\User;
use App\Http\Requests\DirectorateFormRequest;

class DirectorateController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $directorates = Directorate::orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'directorate.listDirectorate', [ 'directorates' => $directorates, 'message' => $message ] );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'directorate.createDirectorate' );
    }

    public function edit( int $directorate_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $directorate = Directorate::findOrFail( $directorate_id );
        
        return view( 'directorate.editDirectorate', [ 'directorate' => $directorate ] );
    }

    public function store( DirectorateFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();

        $description = $request->description;

        $directorate = new Directorate();
        $directorate->description = $description;

        $directorate->save();

        $request->session()->flash('message', "$directorate->description inserida com sucesso!");

        return redirect()->route('listDirectorate');
    }
    
    public function update( DirectorateFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $user_id = Auth::id();
        $description = $request->description;

        $directorate = Directorate::findOrFail($request->id);
        $directorate->description = $description;

        $directorate->save();

        $request->session()->flash('message', "$directorate->description atualizada com sucesso!");

        return redirect()->route('listDirectorate');

    }
 
    public function checkRolePermission( string $role )
    {
        $screen = 'directorate';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}
