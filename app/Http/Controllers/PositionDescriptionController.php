<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\PositionDescription;
use App\Position;
use App\PositionGroup;
use App\Directorate;
use App\Area;
use App\Grade;
use App\GradeCourse;
use App\Competence;
use App\CompetenceType;
use App\CompetenceLevel;
use App\ConfigHideTargetActivity;
use App\ConfigHideTargetClassification;
use App\ConfigPositionGuidelines;
use App\Language;
use App\MainTarget;
use App\MainActivity;
use App\DEPCompetence;
use App\DEPGrade;
use App\DEPLanguage;
use App\DEPMainTarget;
use App\User;
use App\Role;
use App\ConfigPositionInterest;
use App\Http\Requests\PositionDescriptionFormRequest;
// Views
use App\ViewPositionDescription;
use App\ViewPositionDescriptionCourse;
use App\ViewPositionDescriptionCompetence;
use App\ViewPositionDescriptionLanguage;
use App\ViewPositionDescriptionTargetActivity;
// Export Data to File uses:
use App\Exports\PositionDescriptionExport;
use App\Exports\PositionDescriptionExcel;
use Maatwebsite\Excel\Facades\Excel;

class PositionDescriptionController extends Controller
{
    public function index( Request $request )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        set_time_limit(0);

        $positionDescriptions = PositionDescription::with('position')
            ->when($request, function($query) use ($request) {
                // check date range
                if (
                    $request->has('start') && ! empty( $request->input('start') )
                    && $request->has('end') && ! empty( $request->input('end') )
                ) {
                    $query = $query->whereBetween('created_at', [ $request->start, $request->end ]);
                }

                // check interviewed
                if ( $request->has('interviewed') && ! empty( $request->input('interviewed') ) ) {
                    $query = $query->whereIn('interviewed', [ $request->interviewed ]);
                }

                // check search
                if ( $request->has('search') && ! empty( $request->input('search') ) ) {
                    $query = $query->whereHas('position', function($_query) use ($request){
                        $_query->where('description', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('code', 'LIKE', '%' . $request->search . '%');;
                    });
                }

                // check directorate
                if ( $request->has('directorate') && ! empty( $request->input('directorate') ) ) {
                    $query = $query->whereHas('position', function($_query) use ($request) {
                        $_query->where('directorate_id', $request->directorate);
                    });
                }

                // check position group
                if ( $request->has('position_group') && ! empty( $request->input('position_group') ) ) {
                    $query = $query->whereHas('position', function($_query) use ($request) {
                        $_query->where('position_group_id', $request->position_group);
                    });
                }

                return $query;
            })
            ->paginate(15);

        $message = $request->session()->get('message');

        return view( 'positionDescription.listPositionDescription', [
            'positionDescriptions' => $positionDescriptions,
            'request' => json_encode( array(
                'range' => array( 'start' => $request->start, 'end' => $request->end ),
                'interviewed' => $request->interviewed,
                'directorate' => $request->directorate,
                'position_group' => $request->position_group,
                'search' => $request->search
            ), true),
            'message' => $message
        ] );
    }

    public function report( Request $request )
    {
        set_time_limit(0);

        $directorates = Directorate::all();
        $positionGroups = PositionGroup::all();
        $configPositionInterest = ConfigPositionInterest::first();
        $configHideTargetClassification = ConfigHideTargetClassification::first();
        $configPositionGuidelines = ConfigPositionGuidelines::first();
        $configHideTargetActivity = ConfigHideTargetActivity::first();

        $positionDescriptions = PositionDescription::join('position', 'position_description.position_id', '=', 'position.id')
            ->select('position_description.*')
            ->with('position.directorate')
            ->with('position.positionGroup')
            ->with('gradeCourses.grade')
            ->with('gradeCourses.area')
            ->with('languages')
            ->with('targets')
            ->with('activities')
            ->with(['DEPCompetence' => function($query) {
                $query->join('competence', 'competence.id', '=', 'dep_competence.competence_id')
                    ->join('competence_type as type', 'type.id', '=', 'competence.competence_type_id')
                    ->join('competence_level as level', 'level.id', '=', 'dep_competence.level')
                    ->select(
                        'dep_competence.*', 
                        'competence.description as competence_description', 
                        'type.description as type_description', 
                        'level.description as level_description'
                    )
                    ->where('type.description', '<>', 'Sistemas')
                    ->orderBy('type.description', 'asc')
                    ->orderBy('dep_competence.requirement', 'desc')
                    ->orderBy('competence.description', 'asc');
            }])
            ->orderBy('position.description', 'asc')
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
                    $query = $query->whereHas('position', function($_query) use ($request) {
                        $_query->where('description', 'LIKE', '%' . $request->search . '%');
                    });

                    $query = $query->OrWhereHas('DEPGrade', function($_query) use ($request) {
                        $_query->join('grade_course', 'grade_course.id', '=', 'dep_grade.grade_id')
                            ->where('grade_course.description', 'LIKE', '%' . $request->search . '%');
                    });

                    $query = $query->OrWhereHas('DEPCompetence', function($_query) use ($request) {
                        $_query->join('competence', 'competence.id', '=', 'dep_competence.competence_id')
                            ->where('competence.description', 'LIKE', '%' . $request->search . '%');
                    });

                    $query = $query->OrWhereHas('DEPLanguage', function($_query) use ($request) {
                        $_query->join('language', 'language.id', '=', 'dep_language.language_id')
                            ->where('language.description', 'LIKE', '%' . $request->search . '%');
                    });

                    // $query = $query->OrWhereHas('depMainTarget', function($_query) use ($request) {
                    //     $_query->join('dep_maintarget', 'main_target.id', '=', 'dep_maintarget.maintarget_id')
                    //         ->where('main_target.description', 'LIKE', '%' . $request->search . '%');
                    // });

                    $query = $query->OrWhere('restrictions', 'LIKE', '%' . $request->search . '%');
                }

                // check interviewed
                if ( ! Auth::check() ) {
                    $query = $query->whereIn( 'interviewed', [ 'leader' ] );
                    $request->interviewed = 'leader';
                } elseif ( $request->has('interviewed') && ! empty( $request->input('interviewed') ) ) {
                    $query = $query->whereIn('interviewed', [ $request->interviewed ]);
                }

                // check directorate
                if ( $request->has('directorate') && ! empty( $request->input('directorate') ) ) {
                    $query = $query->whereHas('position', function($_query) use ($request) {
                        $_query->where('directorate_id', $request->directorate);
                    });
                }

                // check position group
                if ( $request->has('position_group') && ! empty( $request->input('position_group') ) ) {
                    $query = $query->whereHas('position', function($_query) use ($request) {
                        $_query->where('position_group_id', $request->position_group);
                    });
                }

                // check is Active
                if ( $request->has('is_dep_active') && ! empty( $request->input('is_dep_active') ) ) {
                    $isActive = $request->is_dep_active === 'true' ? 1 : 0;
                    $query = $query->where('is_activated', $isActive);
                }

                return $query;
            })
            ->paginate(15);

        $message = $request->session()->get('message');

        $isDepActive = false;

        if ( $request->has('is_dep_active') && ! empty( $request->input('is_dep_active') ) ) {
            $isDepActive = $request->input('is_dep_active');
        }

        return view( 'positionDescription.reportListPositionDescription',
            [
                'positionDescriptions' => $positionDescriptions,
                'positionGroups' => $positionGroups,
                'directorates' => $directorates,
                'isDepActive' => $isDepActive,
                'configPositionInterest' => $configPositionInterest,
                'configHideTargetClassification' => $configHideTargetClassification,
                'configPositionGuidelines' => $configPositionGuidelines,
                'configHideTargetActivity' => $configHideTargetActivity,
                'request' => json_encode(array(
                    'range' => array( 'start' => $request->start, 'end' => $request->end ),
                    'interviewed' => $request->interviewed,
                    'directorate' => $request->directorate,
                    'position_group' => $request->position_group,
                    'is_dep_active' => $request->is_dep_active,
                    'search' => $request->search
                ), true),
                'message' => $message
            ]
        );
    }

    public function create()
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        set_time_limit(0);

        $positions = Position::all();
        $directorates = Directorate::all();
        $positionGroups = PositionGroup::all();

        $areas = Area::all();
        $grades = Grade::all();
        $gradeCourses = GradeCourse::all();

        $competences = Competence::all();
        $competenceTypes = CompetenceType::orderBy('id', 'asc')->get();
        $competenceLevels = CompetenceLevel::all();
        $languages = Language::all();

        $targets = MainTarget::all();
        $activities = MainActivity::all();

        return view( 'positionDescription.createPositionDescription',
            [
                'positions' => $positions,
                'directorates' => $directorates,
                'positionGroups' => $positionGroups,
                'areas' => $areas,
                'grades' => $grades,
                'gradeCourses' => $gradeCourses,
                'competences' => $competences,
                'competenceTypes' => $competenceTypes,
                'competenceLevels' => $competenceLevels,
                'languages' => $languages,
                'targets' => $targets,
                'activities' => $activities

            ]
        );
    }

    public function store( PositionDescriptionFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'create' ) )
            return view( 'auth.permission' );

        if ( $request->position_id != -1 )
        {
            $allowedRecord = true;
            $positionDescriptions = PositionDescription::where('position_id', $request->position_id)->get();

            foreach ($positionDescriptions as $item )
            {
                if ($item->position_id == $request->position_id && $item->interviewed == $request->interviewed) {
                    $allowedRecord = false;
                }
            }

            if (!$allowedRecord)
            {
                $response['message'] = "Registro para posição e entrevistado já existe";
                $response['status'] = "error";
                $response['allowedRecord'] = $allowedRecord;

                return $response;
            }
        }


        $user_id = Auth::id();
        $newDEP = new PositionDescription();

        $newDEP->interviewed          = $request->interviewed;
        $newDEP->mission              = $request->mission;
        $newDEP->experience_time      = $request->experience_time;
        $newDEP->leadership_time      = $request->leadership_time;
        $newDEP->allowhomeoffice      = $request->allowhomeoffice;
        $newDEP->interviewer_comments = $request->interviewer_comments;
        $newDEP->restrictions         = $request->restrictions;
        $newDEP->company_id           = 1; //Inicial Ypê
        $newDEP->user_id              = $user_id;

        // Cria nova posição caso não exista, senão insere o ID da Posição no registro

        if ( $request->position_id == -1 )
        {
            $position = new Position();
            $position->inserted_by = $user_id;
            $position->description = $request->position;
            $position->save();

            $newDEP->position_id = $position->id;
        } else {
            $newDEP->position_id = $request->position_id;
        }

        // Percorre todos os Cursos e Adiciona caso venha preenchido com Área e Grau
        // Também cria um array onde Serão inseridos os dados para tabela dep_grade

        $dep_grade = array();

        if ( !empty( $request->dep_grade ) )
        {
            foreach ($request->dep_grade as $course)
            {
                if ( $course['grade_course_id'] == -1
                    && !empty($course['grade_course'])
                    && !empty($course['area']) )
                {

                    $grade_course = new GradeCourse();
                    $grade_course->description = $course['grade_course'];
                    $grade_course->area_id = $course['area'];
                    $grade_course->grade_id = $course['grade'];
                    $grade_course->inserted_by = $user_id;
                    $grade_course->save();

                    array_push( $dep_grade, [
                        'grade_id' => $grade_course->id,
                        'status' => $course['status'],
                        'requirement' => $course['requirement']
                    ]);

                } else {
                    array_push( $dep_grade, [
                        'grade_id' => $course['grade_course_id'],
                        'status' => $course['status'],
                        'requirement' => $course['requirement']
                    ]);
                }
            }
        }

        // Percorre todos os Idiomas
        // Também cria um array onde Serão inseridos os dados para tabela dep_language
        $dep_language = array();

        if ( !empty( $request->dep_language ) )
        {
            foreach ($request->dep_language as $language)
            {
                array_push( $dep_language, [
                    'language_id' => $language['language_id'],
                    'skill' => $language['skill'],
                    'level' => $language['level'],
                    'requirement' => $language['requirement']
                ]);
            }
        }

        // Percorre todos as Competências e Adiciona caso venha preenchida
        // Também cria um array onde Serão inseridos os dados para tabela dep_competence

        $dep_competence = array();

        if ( !empty( $request->dep_competence ) )
        {
            foreach ($request->dep_competence as $competence)
            {
                if ( $competence['competence_id'] == -1 ) {

                    $newCompetence = new Competence();
                    $newCompetence->description = $competence['competence'];
                    $newCompetence->competence_type_id = $competence['competence_type_id'];
                    $newCompetence->inserted_by = $user_id;
                    $newCompetence->save();

                    array_push( $dep_competence, [
                        'competence_id' => $newCompetence->id,
                        'level' => $competence['level'],
                        'requirement' => $competence['requirement']
                    ]);

                } else {
                    array_push( $dep_competence, [
                        'competence_id' => $competence['competence_id'],
                        'level' => $competence['level'],
                        'requirement' => $competence['requirement']
                    ]);
                }
            }
        }

        // Percorre todos os Objetivos, suas atividades e Adiciona caso venham preenchidas
        // Também cria um array onde Serão inseridos os dados para tabela dep_maintarget

        $dep_maintarget = array();

        if ( !empty( $request->dep_maintarget ) )
        {
            foreach ($request->dep_maintarget as $target)
            {
                if ( $target['target_id'] == -1 ) {

                    $newTarget = new MainTarget();

                    $newTarget->description = $target['target'];
                    $newTarget->inserted_by = $user_id;

                    $newTarget->save();

                    $target_id = $newTarget->id;
                } else {
                    $target_id = $target['target_id'];
                }

                foreach ($target['activities'] as $activity)
                {
                    if ( $activity['activity_id'] == -1 ) {

                        $newActivity = new MainActivity();

                        $newActivity->description = $activity['activity'];
                        $newActivity->inserted_by = $user_id;

                        $newActivity->save();

                        array_push( $dep_maintarget, [
                            'maintarget_id' => $target_id,
                            'mainactivity_id' => $newActivity->id,
                            'classification' => $activity['classification'],
                            'target_order' => $activity['target_order'],
                            'activity_order' => $activity['activity_order'],
                        ]);

                    } else {
                        
                        array_push( $dep_maintarget, [
                            'maintarget_id' => $target_id,
                            'mainactivity_id' => $activity['activity_id'],
                            'classification' => $activity['classification'],
                            'target_order' => $activity['target_order'],
                            'activity_order' => $activity['activity_order'],
                        ]);
                    }
                }
            }
        }

        $newDEP->save();

        if ( !empty( $dep_grade ) )
        {
            foreach ($dep_grade as $grade)
            {
                $newDEPGrade = new DEPGrade();

                $newDEPGrade->position_description_id = $newDEP->id;
                $newDEPGrade->grade_id = $grade['grade_id'];
                $newDEPGrade->status = $grade['status'];
                $newDEPGrade->requirement = $grade['requirement'];

                $newDEPGrade->save();
            }
        }

        if ( !empty( $dep_language ) )
        {
            foreach ($dep_language as $language)
            {
                $newDEPLanguage = new DEPLanguage();

                $newDEPLanguage->position_description_id = $newDEP->id;
                $newDEPLanguage->language_id = $language['language_id'];
                $newDEPLanguage->skill = $language['skill'];
                $newDEPLanguage->level = $language['level'];
                $newDEPLanguage->requirement = $language['requirement'];

                $newDEPLanguage->save();
            }
        }

        if ( !empty( $dep_competence ) )
        {
            foreach ($dep_competence as $competence)
            {
                $newDEPCompetence = new DEPCompetence();

                $newDEPCompetence->position_description_id = $newDEP->id;
                $newDEPCompetence->competence_id = $competence['competence_id'];
                $newDEPCompetence->level = $competence['level'];
                $newDEPCompetence->requirement = $competence['requirement'];

                $newDEPCompetence->save();
            }
        }

        if ( !empty( $dep_maintarget ) )
        {
            foreach ($dep_maintarget as $target)
            {
                $newDEPMainTarget = new DEPMainTarget();

                $newDEPMainTarget->position_description_id = $newDEP->id;
                $newDEPMainTarget->maintarget_id = $target['maintarget_id'];
                $newDEPMainTarget->mainactivity_id = $target['mainactivity_id'];
                $newDEPMainTarget->classification = $target['classification'];
                $newDEPMainTarget->activity_order = $target['activity_order'];
                $newDEPMainTarget->target_order = $target['target_order'];

                $newDEPMainTarget->save();
            }
        }

        $request->session()->flash('message', "Salvo com sucesso!");

        return $request;
    }

    public function update( PositionDescriptionFormRequest $request )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        $user_id = Auth::id();
        $newDEP = PositionDescription::findOrFail($request->id);

        $newDEP->interviewed          = $request->interviewed;
        $newDEP->mission              = $request->mission;
        $newDEP->experience_time      = $request->experience_time;
        $newDEP->leadership_time      = $request->leadership_time;
        $newDEP->allowhomeoffice      = $request->allowhomeoffice;
        $newDEP->interviewer_comments = $request->interviewer_comments;
        $newDEP->restrictions         = $request->restrictions;
        $newDEP->is_activated         = $request->isactivated == "true" ? 1 : 0;
        $newDEP->company_id           = 1; //Inicial Ypê
        $newDEP->user_id              = $user_id;

        // Percorre todos os Cursos e Adiciona caso venha preenchido com Área e Grau
        // Também cria um array onde Serão inseridos os dados para tabela dep_grade

        $dep_grade = array();

        if ( !empty( $request->dep_grade ) )
        {
            foreach ($request->dep_grade as $course)
            {
                if ( $course['grade_course_id'] == -1
                    && !empty($course['grade_course'])
                    && !empty($course['area']) )
                {

                    $grade_course = new GradeCourse();
                    $grade_course->description = $course['grade_course'];
                    $grade_course->area_id = $course['area'];
                    $grade_course->grade_id = $course['grade'];
                    $grade_course->inserted_by = $user_id;
                    $grade_course->save();

                    array_push( $dep_grade, [
                        'grade_id' => $grade_course->id,
                        'status' => $course['status'],
                        'requirement' => $course['requirement']
                    ]);

                } else {
                    array_push( $dep_grade, [
                        'grade_id' => $course['grade_course_id'],
                        'status' => $course['status'],
                        'requirement' => $course['requirement']
                    ]);
                }
            }
        }

        // Percorre todos os Idiomas
        // Também cria um array onde Serão inseridos os dados para tabela dep_language
        $dep_language = array();

        if ( !empty( $request->dep_language ) )
        {
            foreach ($request->dep_language as $language)
            {
                array_push( $dep_language, [
                    'language_id' => $language['language_id'],
                    'skill' => $language['skill'],
                    'level' => $language['level'],
                    'requirement' => $language['requirement']
                ]);
            }
        }

        // Percorre todos as Competências e Adiciona caso venha preenchida
        // Também cria um array onde Serão inseridos os dados para tabela dep_competence

        $dep_competence = array();

        if ( !empty( $request->dep_competence ) )
        {
            foreach ($request->dep_competence as $competence)
            {
                if ( $competence['competence_id'] == -1 ) {

                    $newCompetence = new Competence();
                    $newCompetence->description = $competence['competence'];
                    $newCompetence->competence_type_id = $competence['competence_type_id'];
                    $newCompetence->inserted_by = $user_id;
                    $newCompetence->save();

                    array_push( $dep_competence, [
                        'competence_id' => $newCompetence->id,
                        'level' => $competence['level'],
                        'requirement' => $competence['requirement']
                    ]);

                } else {
                    array_push( $dep_competence, [
                        'competence_id' => $competence['competence_id'],
                        'level' => $competence['level'],
                        'requirement' => $competence['requirement']
                    ]);
                }
            }
        }

        // Percorre todos os Objetivos, suas atividades e Adiciona caso venham preenchidas
        // Também cria um array onde Serão inseridos os dados para tabela dep_maintarget

        $dep_maintarget = array();

        if ( !empty( $request->dep_maintarget ) )
        {
            foreach ($request->dep_maintarget as $target)
            {
                if ( $target['target_id'] == -1 ) {

                    $newTarget = new MainTarget();

                    $newTarget->description = $target['target'];
                    $newTarget->inserted_by = $user_id;

                    $newTarget->save();

                    $target_id = $newTarget->id;
                } else {
                    $target_id = $target['target_id'];
                }

                foreach ($target['activities'] as $activity)
                {
                    if ( $activity['activity_id'] == -1 ) {

                        $newActivity = new MainActivity();

                        $newActivity->description = $activity['activity'];
                        $newActivity->inserted_by = $user_id;

                        $newActivity->save();

                        array_push( $dep_maintarget, [
                            'maintarget_id' => $target_id,
                            'mainactivity_id' => $newActivity->id,
                            'classification' => $activity['classification'],
                            'target_order' => $activity['target_order'],
                            'activity_order' => $activity['activity_order'],
                        ]);

                    } else {

                        array_push( $dep_maintarget, [
                            'maintarget_id' => $target_id,
                            'mainactivity_id' => $activity['activity_id'],
                            'classification' => $activity['classification'],
                            'target_order' => $activity['target_order'],
                            'activity_order' => $activity['activity_order'],
                        ]);
                    }
                }
            }
        }

        $newDEP->save();

        if ( !empty( $dep_grade ) )
        {
            $depGrade = DEPGrade::where('position_description_id', $request->id);
            $depGrade->delete();

            foreach ($dep_grade as $grade)
            {
                $newDEPGrade = new DEPGrade();

                $newDEPGrade->position_description_id = $request->id;
                $newDEPGrade->grade_id = $grade['grade_id'];
                $newDEPGrade->status = $grade['status'];
                $newDEPGrade->requirement = $grade['requirement'];

                $newDEPGrade->save();
            }
        } else {
            $depGrade = DEPGrade::where('position_description_id', $request->id);
            $depGrade->delete();
        }

        if ( !empty( $dep_language ) )
        {
            $depLanguage = DEPLanguage::where('position_description_id', $request->id);
            $depLanguage->delete();

            foreach ($dep_language as $language)
            {
                $newDEPLanguage = new DEPLanguage();

                $newDEPLanguage->position_description_id = $newDEP->id;
                $newDEPLanguage->language_id = $language['language_id'];
                $newDEPLanguage->skill = $language['skill'];
                $newDEPLanguage->level = $language['level'];
                $newDEPLanguage->requirement = $language['requirement'];

                $newDEPLanguage->save();
            }
        } else {
            $depLanguage = DEPLanguage::where('position_description_id', $request->id);
            $depLanguage->delete();
        }

        if ( !empty( $dep_competence ) )
        {
            $depCompetence = DEPCompetence::where('position_description_id', $request->id);
            $depCompetence->delete();

            foreach ($dep_competence as $competence)
            {
                $newDEPCompetence = new DEPCompetence();

                $newDEPCompetence->position_description_id = $newDEP->id;
                $newDEPCompetence->competence_id = $competence['competence_id'];
                $newDEPCompetence->level = $competence['level'];
                $newDEPCompetence->requirement = $competence['requirement'];

                $newDEPCompetence->save();
            }
        } else {
            $depCompetence = DEPCompetence::where('position_description_id', $request->id);
            $depCompetence->delete();
        }

        if ( !empty( $dep_maintarget ) )
        {
            $depMainTarget = DEPMainTarget::where('position_description_id', $request->id);
            $depMainTarget->delete();

            foreach ($dep_maintarget as $target)
            {
                $newDEPMainTarget = new DEPMainTarget();

                $newDEPMainTarget->position_description_id = $newDEP->id;
                $newDEPMainTarget->maintarget_id = $target['maintarget_id'];
                $newDEPMainTarget->mainactivity_id = $target['mainactivity_id'];
                $newDEPMainTarget->classification = $target['classification'];
                $newDEPMainTarget->activity_order = $target['activity_order'];
                $newDEPMainTarget->target_order = $target['target_order'];

                $newDEPMainTarget->save();
            }
        } else {
            $depMainTarget = DEPMainTarget::where('position_description_id', $request->id);
            $depMainTarget->delete();
        }

        $request->session()->flash('message', "Salvo com sucesso!");

        return $request;
    }

    public function validatePositionDescription( $position_id, $interviewed )
    {
        if ( ! $this->checkRolePermission( 'validate' ) )
            return view( 'auth.permission' );

        $positionDescriptions = PositionDescription::where('position_id', $position_id)
            ->get();

        foreach ($positionDescriptions as $item )
        {
            if ($item->position_id == $position_id && $item->interviewed == $interviewed) {
                return $item;
            }
        }

    }

    public function validateDEP( int $positionDescriptionId )
    {
        if ( ! $this->checkRolePermission( 'validate' ) )
            return view( 'auth.permission' );

        set_time_limit(0);

        // Get data to validate
        $positionDescriptions = PositionDescription::find($positionDescriptionId);
        $depGrades = DEPGrade::where('position_description_id', $positionDescriptionId)->get();
        $depLanguages = DEPLanguage::where('position_description_id', $positionDescriptionId)->get();
        $depCompetences = DEPCompetence::where('position_description_id', $positionDescriptionId)->get();
        $depMainTargets = DEPMainTarget::where('position_description_id', $positionDescriptionId)->get();

        // Get data for Autocomplete and Select fields
        $positions = Position::all();
        $directorates = Directorate::all();
        $positionGroups = PositionGroup::all();
        $areas = Area::all();
        $grades = Grade::all();
        $gradeCourses = GradeCourse::all();
        $competences = Competence::all();
        $competenceTypes = CompetenceType::all()->sortBy('id');
        $competenceLevels = CompetenceLevel::all();
        $languages = Language::all();
        $targets = MainTarget::all();
        $activities = MainActivity::all();

        return view( 'positionDescription.validatePositionDescription',
            [
                'positionDescriptions' => $positionDescriptions,
                'depGrades' => $depGrades,
                'depLanguages' => $depLanguages,
                'depCompetences' => $depCompetences,
                'depMainTargets' => $depMainTargets,
                'positions' => $positions,
                'directorates' => $directorates,
                'positionGroups' => $positionGroups,
                'areas' => $areas,
                'grades' => $grades,
                'gradeCourses' => $gradeCourses,
                'competences' => $competences,
                'competenceTypes' => $competenceTypes,
                'competenceLevels' => $competenceLevels,
                'languages' => $languages,
                'targets' => $targets,
                'activities' => $activities

            ]
        );
    }

    public function edit( int $positionDescriptionId )
    {
        if ( ! $this->checkRolePermission( 'update' ) )
            return view( 'auth.permission' );

        set_time_limit(0);

        // Get data to validate
        $positionDescriptions = PositionDescription::find($positionDescriptionId);
        $depGrades = DEPGrade::where('position_description_id', $positionDescriptionId)->get();
        $depLanguages = DEPLanguage::where('position_description_id', $positionDescriptionId)->get();
        $depCompetences = DEPCompetence::where('position_description_id', $positionDescriptionId)->get();
        $depMainTargets = DEPMainTarget::where('position_description_id', $positionDescriptionId)->get();

        // Get data for Autocomplete and Select fields
        $positions = Position::all();
        $directorates = Directorate::all();
        $positionGroups = PositionGroup::all();
        $areas = Area::all();
        $grades = Grade::all();
        $gradeCourses = GradeCourse::all();
        $competences = Competence::all();
        $competenceTypes = CompetenceType::all();
        $competenceLevels = CompetenceLevel::all();
        $languages = Language::all();
        $targets = MainTarget::all();
        $activities = MainActivity::all();

        return view( 'positionDescription.editPositionDescription',
            [
                'positionDescriptions' => $positionDescriptions,
                'depGrades' => $depGrades,
                'depLanguages' => $depLanguages,
                'depCompetences' => $depCompetences,
                'depMainTargets' => $depMainTargets,
                'positions' => $positions,
                'directorates' => $directorates,
                'positionGroups' => $positionGroups,
                'areas' => $areas,
                'grades' => $grades,
                'gradeCourses' => $gradeCourses,
                'competences' => $competences,
                'competenceTypes' => $competenceTypes,
                'competenceLevels' => $competenceLevels,
                'languages' => $languages,
                'targets' => $targets,
                'activities' => $activities

            ]
        );
    }

    public function getPositionDescription( int $positionDescriptionId )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        set_time_limit(0);

        $positionDescriptions = PositionDescription::with('position')
            ->with('gradeCourses.grade')
            ->with('gradeCourses.area')
            ->with('languages')
            ->with('targets')
            ->with('activities')
            ->with(['DEPCompetence' => function($query) {
                $query->join('competence', 'competence.id', '=', 'dep_competence.competence_id')
                    ->join('competence_type as type', 'type.id', '=', 'competence.competence_type_id')
                    ->join('competence_level as level', 'level.id', '=', 'dep_competence.level')
                    ->select(
                        'dep_competence.*', 
                        'competence.description as competence_description', 
                        'type.description as type_description', 
                        'level.description as level_description'
                    )
                    ->where('type.description', '<>', 'Sistemas')
                    ->orderBy('type.description', 'asc')
                    ->orderBy('dep_competence.requirement', 'desc')
                    ->orderBy('competence.description', 'asc');
            }])
            ->findOrfail($positionDescriptionId);

        return view( 'positionDescription.readPositionDescription',
            [
                'positionDescriptions' => $positionDescriptions
            ]
        );
    }


    public function getRawPositionDescription( int $positionDescriptionId )
    {
        if ( ! $this->checkRolePermission( 'read' ) )
            return view( 'auth.permission' );

        set_time_limit(0);

        $positionDescriptions = PositionDescription::with('position')
            ->with('gradeCourses.grade')
            ->with('gradeCourses.area')
            ->with('languages')
            ->with('competences')
            ->with('competences.competenceType')
            ->with('competenceLevel')
            ->with('targets')
            ->with('activities')
            ->findOrfail($positionDescriptionId);

        return view( 'positionDescription.readRawPositionDescription',
            [
                'positionDescriptions' => $positionDescriptions
            ]
        );
    }

    public function checkRolePermission( string $role )
    {
        $screen = 'position_description';
        $userId = Auth::id();

        $user = User::find( $userId );

        $has_permission = $user->roles->where( 'role', $role );

        if ( $has_permission->count() )
            return true;
        else
            return false;
    }

    public function exportXLSX()
    {
        if ( ! $this->checkRolePermission( 'exportxlsx' ) )
            return view( 'auth.permission' );

        $positionDescription = ViewPositionDescription::all();
        $positionDescriptionCourse = ViewPositionDescriptionCourse::all();

        return (new PositionDescriptionExcel)->download('dep.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportPDF(int $positionDescriptionId)
    {
        return (new PositionDescriptionExport($positionDescriptionId))->download('dep.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }
}