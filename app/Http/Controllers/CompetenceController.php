<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CompetenceLevel;
use App\CompetenceType;
use App\Competence;
use App\User;
use App\Http\Requests\CompetenceFormRequest;

class CompetenceController extends Controller
{
    public function index( Request $request )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $competences = Competence::with('competenceType')
            ->when($request, function($query) use ($request) {
                // check date range
                if (
                    $request->has('start') && ! empty( $request->input('start') )
                    && $request->has('end') && ! empty( $request->input('end') )
                ) {
                    $query = $query->whereBetween('created_at', [ $request->start, $request->end ]);
                }

                // check search
                if ( $request->has('search') && ! empty( $request->input('search') ) ) {
                    $query = $query->where('description', 'LIKE', '%' . $request->search . '%');
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $message = $request->session()->get('message');

        return view( 'competence.listCompetence', [
            'competences' => $competences,
            'message' => $message,
            'request' => json_encode( array(
                'range' => array( 'start' => $request->start, 'end' => $request->end ),
                'search' => $request->search
            ), true),
        ] );
    }

    public function create()
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $competence_types = CompetenceType::all();

        return view( 'competence.createCompetence',
            [
                'competence_types' => $competence_types
            ]
        );
    }

    public function edit( int $competence_id )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $competence = Competence::findOrFail( $competence_id );
        $competence_types = CompetenceType::all();

        return view( 'competence.editCompetence',
            [
                'competence' => $competence,
                'competence_types' => $competence_types
            ]
        );
    }

    public function store( CompetenceFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();
        $competence = new Competence();

        $competence->description = $request->description;
        $competence->competence_type_id = $request->competence_type;
        $competence->inserted_by = $user_id;

        $competence->save();

        $request->session()->flash('message', "$competence->description inserida com sucesso!");

        return redirect()->route('listCompetence');
    }

    public function update( CompetenceFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();

        $competence = Competence::findOrFail($request->id);
        $competence->description = $request->description;
        $competence->competence_type_id = $request->competence_type;
        $competence->inserted_by = $user_id;

        $competence->save();

        $request->session()->flash('message', "$competence->description atualizada com sucesso!");

        return redirect()->route('listCompetence');

    }

    public function checkRolePermission( string $role )
    {
        $screen = 'competence';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else
            return false;
    }
}
