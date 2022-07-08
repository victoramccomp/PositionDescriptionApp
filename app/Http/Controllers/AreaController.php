<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Area;
use App\User;
use App\Http\Requests\AreaFormRequest;

class AreaController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $areas = Area::orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'area.listArea', [ 'areas' => $areas, 'message' => $message ] );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'area.createArea' );
    }

    public function edit( int $area_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $area = Area::findOrFail( $area_id );
        
        return view( 'area.editArea', [ 'area' => $area ] );
    }

    public function store( AreaFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $area = new Area();
        $area->description = $request->description;

        $area->save();

        $request->session()->flash('message', "$area->description inserida com sucesso!");

        return redirect()->route('listArea');
    }

    public function update( AreaFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $area = Area::findOrFail($request->id);
        $area->description = $request->description;

        $area->save();

        $request->session()->flash('message', "$area->description atualizada com sucesso!");

        return redirect()->route('listArea');
    }
    
    public function checkRolePermission( string $role )
    {
        $screen = 'area';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}
