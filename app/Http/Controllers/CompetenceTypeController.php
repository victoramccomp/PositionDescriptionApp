<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CompetenceType;
use App\User;
use App\Http\Requests\CompetenceTypeFormRequest;

class CompetenceTypeController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $competence_types = CompetenceType::orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'competenceType.listCompetenceType', [ 'competence_types' => $competence_types, 'message' => $message ] );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'competenceType.createCompetenceType' );
    }

    public function edit( int $competence_type_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $competence_type = CompetenceType::findOrFail( $competence_type_id );
        
        return view( 'competenceType.editCompetenceType', [ 'competenceType' => $competence_type ] );
    }

    public function store( CompetenceTypeFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $description = $request->description;
        
        $competence_type = new CompetenceType();
        $competence_type->description = $description;
        
        $competence_type->save();

        $request->session()->flash('message', "$competence_type->description inserida com sucesso!");

        return redirect()->route('listCompetenceType');
    }

    public function update( CompetenceTypeFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $description = $request->description;

        $competence_type = CompetenceType::findOrFail($request->id);
        $competence_type->description = $description;

        $competence_type->save();

        $request->session()->flash('message', "$competence_type->description atualizada com sucesso!");

        return redirect()->route('listCompetenceType');

    }
    
    public function checkRolePermission( string $role )
    {
        $screen = 'competence_type';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}