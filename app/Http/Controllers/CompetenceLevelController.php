<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CompetenceLevel;
use App\CompetenceType;
use App\User;
use App\Http\Requests\CompetenceLevelFormRequest;

class CompetenceLevelController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $competence_levels = CompetenceLevel::with('competenceType')->orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'competenceLevel.listCompetenceLevel', [ 'competence_levels' => $competence_levels, 'message' => $message ] );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $competence_types = CompetenceType::all();

        return view( 'competenceLevel.createCompetenceLevel', [ 'competence_types' => $competence_types ] );
    }

    public function edit( int $competence_level_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $competence_level = CompetenceLevel::findOrFail( $competence_level_id );
        $competence_types = CompetenceType::all();

        return view( 'competenceLevel.editCompetenceLevel', 
            [ 
                'competence_level' => $competence_level,
                'competence_types' => $competence_types
            ] );
    }

    public function store( CompetenceLevelFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $competence_level = new CompetenceLevel();
        
        $competence_level->description = $request->description;
        $competence_level->competence_type_id = $request->competence_type;

        $competence_level->save();

        $request->session()->flash('message', "$competence_level->description inserida com sucesso!");

        return redirect()->route('listCompetenceLevel');
    }

    public function update( CompetenceLevelFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $competence_level = CompetenceLevel::findOrFail($request->id);
        $competence_level->description = $request->description;
        $competence_level->competence_type_id = $request->competence_type;

        $competence_level->save();

        $request->session()->flash('message', "$competence_level->description atualizada com sucesso!");

        return redirect()->route('listCompetenceLevel');

    }
    
    public function checkRolePermission( string $role )
    {
        $screen = 'competence_level';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}