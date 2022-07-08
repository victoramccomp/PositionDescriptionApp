<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\UserRole;
use App\Http\Requests\UserRoleFormRequest;

class UserRoleController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );

        $users = User::orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'role.listUserRoles', [ 'users' => $users, 'message' => $message ] );
    }

    public function edit( int $user_id ) 
    {
        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );

        $user = User::findOrFail( $user_id );

        $roles = Role::all();

        $userRoles = $user->roles;
        
        return view( 'role.editUserRoles', 
            [ 
                'userRoles' => $userRoles, 
                'roles' => $roles, 
                'user' => $user 
            ] 
        );
    }

    public function update( UserRoleFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );

        // $request->roles = "1,2,3,4,5,6"; so, we need to explode to create an array
        $roles = explode(',', $request->roles);

        if ( ! empty( $roles ) )
        {
            // Remove roles from user
            $userRole = UserRole::where('user_id', $request->user_id);
            $userRole->delete();

            // Run Roles and save the new Roles
            foreach ($roles as $role) 
            { 
                $newUserRole = new UserRole();

                $newUserRole->user_id = $request->user_id;
                $newUserRole->role_id = $role;
                
                $newUserRole->save();
            }
        }

        $request->session()->flash('message', "Permissões atualizadas com sucesso!");

        return redirect()->route('listUserRoles');
    }

    public function checkRolePermission( string $role )
    {
        $screen = 'role';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}
