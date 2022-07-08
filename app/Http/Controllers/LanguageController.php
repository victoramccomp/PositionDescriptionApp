<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Language;
use App\User;
use App\Http\Requests\LanguageFormRequest;

class LanguageController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $languages = Language::orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'language.listLanguage', [ 'languages' => $languages, 'message' => $message ] );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'language.createLanguage' );
    }

    public function edit( int $language_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $language = Language::findOrFail( $language_id );
        
        return view( 'language.editLanguage', [ 'language' => $language ] );
    }

    public function store( LanguageFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $language = new Language();
        $language->description = $request->description;

        $language->save();

        $request->session()->flash('message', "$language->description inserido com sucesso!");

        return redirect()->route('listLanguage');
    }

    public function update( LanguageFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $language = Language::findOrFail($request->id);
        $language->description = $request->description;

        $language->save();

        $request->session()->flash('message', "$language->description atualizado com sucesso!");

        return redirect()->route('listLanguage');
    }

    public function checkRolePermission( string $role )
    {
        $screen = 'language';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}
