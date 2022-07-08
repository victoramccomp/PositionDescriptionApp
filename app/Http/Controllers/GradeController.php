<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Grade;
use App\User;
use App\Http\Requests\GradeFormRequest;

class GradeController extends Controller
{
    public function index( Request $request ) 
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $grades = Grade::orderBy('id', 'DESC')->paginate(20);

        $message = $request->session()->get('message');

        return view( 'grade.listGrade', [ 'grades' => $grades, 'message' => $message ] );
    }

    public function create() 
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        return view( 'grade.createGrade' );
    }

    public function edit( int $grade_id ) 
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $grade = Grade::findOrFail( $grade_id );
        
        return view( 'grade.editGrade', [ 'grade' => $grade ] );
    }

    public function store( GradeFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $grade = new Grade();
        $grade->description = $request->description;

        $grade->save();

        $request->session()->flash('message', "$grade->description inserido com sucesso!");

        return redirect()->route('listGrade');
    }

    public function update( GradeFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );
            
        $grade = Grade::findOrFail($request->id);
        $grade->description = $request->description;

        $grade->save();

        $request->session()->flash('message', "$grade->description atualizado com sucesso!");

        return redirect()->route('listGrade');
    }
    
    public function checkRolePermission( string $role )
    {
        $screen = 'grade';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else 
            return false;
    }
}