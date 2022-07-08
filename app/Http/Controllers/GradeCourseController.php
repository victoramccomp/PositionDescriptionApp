<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\GradeCourse;
use App\Grade;
use App\Area;
use App\User;
use App\Http\Requests\GradeCourseFormRequest;

class GradeCourseController extends Controller
{
    public function index( Request $request )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        $gradeCourses = GradeCourse::with('grade')
            ->with('area')
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

        return view( 'gradeCourse.listGradeCourse',
            [
                'gradeCourses' => $gradeCourses,
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

        $grades = Grade::all();
        $areas = Area::all();

        return view( 'gradeCourse.createGradeCourse',
            [
                'grades' => $grades,
                'areas' => $areas,
            ]
        );
    }

    public function edit( int $grade_course_id )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $gradeCourse = GradeCourse::findOrFail( $grade_course_id );
        $grades = Grade::all();
        $areas = Area::all();

        return view( 'gradeCourse.editGradeCourse',
            [
                'gradeCourse' => $gradeCourse,
                'grades' => $grades,
                'areas' => $areas,
            ]
        );
    }

    public function store( GradeCourseFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();

        $gradeCourse = new GradeCourse();
        $gradeCourse->description = $request->description;
        $gradeCourse->area_id = $request->area;
        $gradeCourse->grade_id = $request->grade;
        $gradeCourse->inserted_by = $user_id;

        $gradeCourse->save();

        $request->session()->flash('message', "$gradeCourse->description inserido com sucesso!");

        return redirect()->route('listGradeCourse');
    }

    public function update( GradeCourseFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();

        $gradeCourse = GradeCourse::findOrFail($request->id);
        $gradeCourse->description = $request->description;
        $gradeCourse->area_id = $request->area;
        $gradeCourse->grade_id = $request->grade;
        $gradeCourse->inserted_by = $user_id;

        $gradeCourse->save();

        $request->session()->flash('message', "$gradeCourse->description atualizado com sucesso!");

        return redirect()->route('listGradeCourse');
    }

    public function checkRolePermission( string $role )
    {
        $screen = 'grade_course';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else
            return false;
    }
}
