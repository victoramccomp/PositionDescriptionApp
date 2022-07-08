<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Position;
use App\PositionGroup;
use App\Directorate;
use App\Exports\PositionExcel;
use App\User;
use App\Http\Requests\PositionFormRequest;
use App\PositionDescription;

class PositionController extends Controller
{
    public function index( Request $request )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $positions = Position::with('positionGroup')
            ->with('directorate')
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
                    $query = $query->where('description', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('code', 'LIKE', '%' . $request->search . '%');
                }
            })
            ->paginate(20);


        $message = $request->session()->get('message');

        return view( 'position.listPosition',
            [
                'positions' => $positions,
                'message' => $message,
                'request' => json_encode( array(
                    'range' => array( 'start' => $request->start, 'end' => $request->end ),
                    'search' => $request->search
                ), true),
            ]
        );
    }

    public function create()
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $positionGroups = PositionGroup::all();
        $directorates = Directorate::all();

        return view( 'position.createPosition',
            [
                'positionGroups' => $positionGroups,
                'directorates' => $directorates
            ]
        );
    }

    public function edit( int $position_id )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $position = Position::findOrFail( $position_id );

        $positionGroups = PositionGroup::all();
        $directorates = Directorate::all();

        return view( 'position.editPosition',
            [
                'position' => $position,
                'positionGroups' => $positionGroups,
                'directorates' => $directorates
            ]
        );
    }

    public function store( PositionFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();

        $description = $request->description;
        $position_group_id = $request->positiongroup;
        $directorate_id = $request->directorate;
        $code = $request->code;
        $salary_grade = $request->salarygrade;

        $position = new Position();
        $position->description = $description;
        $position->position_group_id = $position_group_id > 0 ? $position_group_id : NULL;
        $position->directorate_id = $directorate_id > 0 ? $directorate_id : NULL;
        $position->code = $code;
        $position->salary_grade = $salary_grade;
        $position->inserted_by = $user_id;

        $position->save();

        $request->session()->flash('message', "$position->description inserida com sucesso!");

        return redirect()->route('listPosition');
    }

    public function update( PositionFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();
        $description = $request->description;
        $position_group_id = $request->positiongroup;
        $directorate_id = $request->directorate;
        $code = $request->code;
        $salary_grade = $request->salarygrade;

        $position = Position::findOrFail($request->id);
        $position->description = $description;
        $position->position_group_id = $position_group_id > 0 ? $position_group_id : NULL;
        $position->directorate_id = $directorate_id > 0 ? $directorate_id : NULL;
        $position->code = $code;
        $position->salary_grade = $salary_grade;
        $position->inserted_by = $user_id;

        $position->save();

        $request->session()->flash('message', "$position->description atualizada com sucesso!");

        return redirect()->route('listPosition');

    }

    public function destroy( int $position_id )
    {
        $dep = PositionDescription::where('position_id', $position_id );

        if ( $dep->count() === 0 ) {
            Position::where('id', $position_id)->delete();
            return redirect()->route('listPosition')->with('status', 'Posição excluída com sucesso!');
        }

        return redirect()->route('listPosition')->with('status', 'Posição não pode ser apagada pois existe uma Descrição de Posição!');
    }

    public function exportXLSX()
    {
        if ( ! $this->checkRolePermission( 'exportxlsx' ) )
            return view( 'auth.permission' );

        return (new PositionExcel)->download('positions.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function checkRolePermission( string $role )
    {
        $screen = 'position';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else
            return false;
    }
}
