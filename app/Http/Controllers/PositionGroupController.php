<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PositionGroup;
use App\User;
use App\Http\Requests\PositionGroupFormRequest;

class PositionGroupController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );
        
        $positionGroups = PositionGroup::orderBy('id', 'DESC')->paginate(20);
        
        $message = $request->session()->get('message');

        return view( 'positionGroup.listPositionGroup', 
            [ 
                'positionGroups' => $positionGroups, 
                'message' => $message 
            ] 
        );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'positionGroup.createPositionGroup' );
    }

    public function edit( int $position_group_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $positionGroup = PositionGroup::findOrFail( $position_group_id );
        
        return view( 'positionGroup.editPositionGroup', [ 'positionGroup' => $positionGroup ] );
    }

    public function store( PositionGroupFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();

        $description = $request->description;

        $position_group = new PositionGroup();
        $position_group->description = $description;

        $position_group->save();

        $request->session()->flash('message', "$position_group->description inserida com sucesso!");

        return redirect()->route('listPositionGroup');
    }
    
    public function update( PositionGroupFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $user_id = Auth::id();
        $description = $request->description;

        $position_group = PositionGroup::findOrFail($request->id);
        $position_group->description = $description;

        $position_group->save();

        $request->session()->flash('message', "$position_group->description atualizada com sucesso!");

        return redirect()->route('listPositionGroup');

    }
 
    public function checkRolePermission( string $role )
    {
        $screen = 'position_group';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}
