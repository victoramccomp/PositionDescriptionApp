<?php

namespace App\Http\Controllers;

use App\ConfigHideTargetActivity;
use App\ConfigHideTargetClassification;
use App\ConfigPositionGuidelines;
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
        $configHideTargetClassification = ConfigHideTargetClassification::first();
        $configHideTargetActivity = ConfigHideTargetActivity::first();
        $configPositionGuidelines = ConfigPositionGuidelines::first();

        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );

        return view( 'config.editConfig', [ 
            'configPositionInterest' => $configPositionInterest,
            'configHideTargetClassification' => $configHideTargetClassification,
            'configHideTargetActivity' => $configHideTargetActivity,
            'configPositionGuidelines' => $configPositionGuidelines 
        ] );
    }

    public function update( ConfigFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'admin' ) )
            return view( 'auth.permission' );


        $isHidden = isset( $request->is_hidden ) ? 1 : 0;
        $isHiddenActivity = isset( $request->is_hidden_activity ) ? 1 : 0;
        $isActivated = isset( $request->is_activated );

        $configHideTargetClassification = ConfigHideTargetClassification::findOrFail( $request->config_hide_target_classification_id );
        $configHideTargetClassification->is_hidden = $isHidden;

        $configHideTargetActivity = ConfigHideTargetActivity::findOrFail( $request->config_hide_target_activity_id );
        $configHideTargetActivity->is_hidden = $isHiddenActivity;

        $configPositionGuidelines = ConfigPositionGuidelines::findOrFail($request->config_guidelines_id);
        $configPositionGuidelines->guidelines = $request->guidelines;

        $configPositionInterest = ConfigPositionInterest::findOrFail($request->id);
        $configPositionInterest->is_activated = $isActivated;
        $configPositionInterest->terms_and_privacy = $request->terms_and_privacy;

        $configHideTargetClassification->save();
        $configHideTargetActivity->save();
        $configPositionGuidelines->save();
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
