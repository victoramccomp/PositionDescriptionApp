<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ConfigPositionInterest;
use App\User;
use App\Http\Requests\ConfigFormRequest;

class ConfigController extends Controller
{

    public function edit() 
    {
        $configPositionInterest = ConfigPositionInterest::first();

        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );

        return view( 'config.editConfig', [ 'configPositionInterest' => $configPositionInterest ] );
    }

    public function update( ConfigFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );

        $isActivated = isset( $request->is_activated );

        $configPositionInterest = ConfigPositionInterest::findOrFail($request->id);
        $configPositionInterest->is_activated = $isActivated;
        $configPositionInterest->terms_and_privacy = $request->terms_and_privacy;

        $configPositionInterest->save();

        $request->session()->flash('message', "Atualização feita com sucesso!");

        return redirect()->route('editConfig');

    }
    
    public function checkRolePermission( string $role )
    {
        $screen = 'config';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}
