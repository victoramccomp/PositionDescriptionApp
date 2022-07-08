<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//User
Route::get('/user', ['middleware' => 'auth', 'uses' => 'UserController@index'] )->name('listUser');
Route::get('/user/create', ['middleware' => 'auth', 'uses' => 'UserController@create'] )->name('createUser');
Route::post('/user/create', ['middleware' => 'auth', 'uses' => 'UserController@store'] )->name('storeUser');
Route::get('/user/edit/{user_id}', ['middleware' => 'auth', 'uses' => 'UserController@edit'] )->name('editUser');
Route::post('/user/update', ['middleware' => 'auth', 'uses' => 'UserController@update'] )->name('updateUser');

// Position Description
Route::get('/positiondescription/report', ['uses' => 'PositionDescriptionController@report'])->name('reportListPositionDescription');
Route::get('/positiondescription', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@index'])->name('listPositionDescription');
Route::get('/positiondescription/create', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@create'])->name('createPositionDescription');
Route::post('/positiondescription/create', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@store'])->name('storePositionDescription');
Route::post('/positiondescription/update', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@update'])->name('updatePositionDescription');
Route::get('/positiondescription/edit/{positionDescriptionId}', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@edit'])->name('editPositionDescription');
Route::get('/positiondescription/getPositionDescription/{positionDescriptionId}', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@getPositionDescription'])->name('getPositionDescription');
Route::get('/positiondescription/validateDEP/{positionDescriptionId}', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@validateDEP'])->name('validatePositionDescription');
Route::get('/positiondescription/exportXLSX', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@exportXLSX'])->name('exportXLSXPositionDescription');
Route::get('/positiondescription/exportPDF/{positionDescriptionId}', ['middleware' => 'auth', 'uses' => 'PositionDescriptionController@exportPDF'])->name('exportPDFPositionDescription');

// Position
Route::get('/position', ['middleware' => 'auth', 'uses' => 'PositionController@index'] )->name('listPosition');
Route::get('/position/create', ['middleware' => 'auth', 'uses' => 'PositionController@create'] )->name('createPosition');
Route::post('/position/create', ['middleware' => 'auth', 'uses' => 'PositionController@store'] )->name('storePosition');
Route::get('/position/edit/{position_id}', ['middleware' => 'auth', 'uses' => 'PositionController@edit'] )->name('editPosition');
Route::post('/position/update', ['middleware' => 'auth', 'uses' => 'PositionController@update'] )->name('updatePosition');
Route::get('/position/exportXLSX', ['middleware' => 'auth', 'uses' => 'PositionController@exportXLSX'])->name('exportXLSXPosition');
Route::get('/position/delete/{position_id}', ['middleware' => 'auth', 'uses' => 'PositionController@destroy'] )->name('deletePosition');

// Competence Type
Route::get('/competenceType', ['middleware' => 'auth', 'uses' => 'CompetenceTypeController@index'] )->name('listCompetenceType');
Route::get('/competenceType/create', ['middleware' => 'auth', 'uses' => 'CompetenceTypeController@create'] )->name('creatCompetenceType');
Route::post('/competenceType/create', ['middleware' => 'auth', 'uses' => 'CompetenceTypeController@store'] )->name('storeCompetenceType');
Route::get('/competenceType/edit/{competence_type_id}', ['middleware' => 'auth', 'uses' => 'CompetenceTypeController@edit'] )->name('editCompetenceType');
Route::post('/competenceType/update', ['middleware' => 'auth', 'uses' => 'CompetenceTypeController@update'] )->name('updateCompetenceType');

// Competence Level
Route::get('/competenceLevel', ['middleware' => 'auth', 'uses' => 'CompetenceLevelController@index'] )->name('listCompetenceLevel');
Route::get('/competenceLevel/create', ['middleware' => 'auth', 'uses' => 'CompetenceLevelController@create'] )->name('createCompetenceLevel');;
Route::post('/competenceLevel/create', ['middleware' => 'auth', 'uses' => 'CompetenceLevelController@store'] )->name('storeCompetenceLevel');;
Route::get('/competenceLevel/edit/{competence_level_id}', ['middleware' => 'auth', 'uses' => 'CompetenceLevelController@edit'] )->name('editCompetenceLevel');
Route::post('/competenceLevel/update', ['middleware' => 'auth', 'uses' => 'CompetenceLevelController@update'] )->name('updateCompetenceLevel');

// Competence
Route::get('/competence', ['middleware' => 'auth', 'uses' => 'CompetenceController@index'] )->name('listCompetence');
Route::get('/competence/create', ['middleware' => 'auth', 'uses' => 'CompetenceController@create'] )->name('createCompetence');;
Route::post('/competence/create', ['middleware' => 'auth', 'uses' => 'CompetenceController@store'] )->name('storeCompetence');;
Route::get('/competence/edit/{competence_id}', ['middleware' => 'auth', 'uses' => 'CompetenceController@edit'] )->name('editCompetence');
Route::post('/competence/update', ['middleware' => 'auth', 'uses' => 'CompetenceController@update'] )->name('updateCompetence');

// Grade
Route::get('/grade', ['middleware' => 'auth', 'uses' => 'GradeController@index'] )->name('listGrade');
Route::get('/grade/create', ['middleware' => 'auth', 'uses' => 'GradeController@create'] )->name('createGrade');
Route::post('/grade/create', ['middleware' => 'auth', 'uses' => 'GradeController@store'] )->name('storeGrade');
Route::get('/grade/edit/{grade_id}', ['middleware' => 'auth', 'uses' => 'GradeController@edit'] )->name('editGrade');
Route::post('/grade/update', ['middleware' => 'auth', 'uses' => 'GradeController@update'] )->name('updateGrade');

// Area
Route::get('/area', ['middleware' => 'auth', 'uses' => 'AreaController@index'] )->name('listArea');
Route::get('/area/create', ['middleware' => 'auth', 'uses' => 'AreaController@create'] )->name('createArea');
Route::post('/area/create', ['middleware' => 'auth', 'uses' => 'AreaController@store'] )->name('storeArea');
Route::get('/area/edit/{area_id}', ['middleware' => 'auth', 'uses' => 'AreaController@edit'] )->name('editArea');
Route::post('/area/update', ['middleware' => 'auth', 'uses' => 'AreaController@update'] )->name('updateArea');

// Grade Course
Route::get('/gradeCourse', ['middleware' => 'auth', 'uses' => 'GradeCourseController@index'] )->name('listGradeCourse');
Route::get('/gradeCourse/create', ['middleware' => 'auth', 'uses' => 'GradeCourseController@create'] )->name('createGradeCourse');
Route::post('/gradeCourse/create', ['middleware' => 'auth', 'uses' => 'GradeCourseController@store'] )->name('storeGradeCourse');
Route::get('/gradeCourse/edit/{grade_course_id}', ['middleware' => 'auth', 'uses' => 'GradeCourseController@edit'] )->name('editGradeCourse');
Route::post('/gradeCourse/update', ['middleware' => 'auth', 'uses' => 'GradeCourseController@update'] )->name('updateGradeCourse');

// Language
Route::get('/language', ['middleware' => 'auth', 'uses' => 'LanguageController@index'] )->name('listLanguage');
Route::get('/language/create', ['middleware' => 'auth', 'uses' => 'LanguageController@create'] )->name('createLanguage');
Route::post('/language/create', ['middleware' => 'auth', 'uses' => 'LanguageController@store'] )->name('storeLanguage');
Route::get('/language/edit/{language_id}', ['middleware' => 'auth', 'uses' => 'LanguageController@edit'] )->name('editLanguage');
Route::post('/language/update', ['middleware' => 'auth', 'uses' => 'LanguageController@update'] )->name('updateLanguage');

// Role
Route::get('/userRole', ['middleware' => 'auth', 'uses' => 'UserRoleController@index'] )->name('listUserRoles');
Route::get('/userRole/edit/{user_id}', ['middleware' => 'auth', 'uses' => 'UserRoleController@edit'] )->name('editUserRoles');
Route::post('/userRole/update', ['middleware' => 'auth', 'uses' => 'UserRoleController@update'] )->name('updateUserRoles');

// Position Group
Route::get('/positionGroup', ['middleware' => 'auth', 'uses' => 'PositionGroupController@index'] )->name('listPositionGroup');
Route::get('/positionGroup/create', ['middleware' => 'auth', 'uses' => 'PositionGroupController@create'] )->name('createPositionGroup');
Route::post('/positionGroup/create', ['middleware' => 'auth', 'uses' => 'PositionGroupController@store'] )->name('storePositionGroup');
Route::get('/positionGroup/edit/{position_group_id}', ['middleware' => 'auth', 'uses' => 'PositionGroupController@edit'] )->name('editPositionGroup');
Route::post('/positionGroup/update', ['middleware' => 'auth', 'uses' => 'PositionGroupController@update'] )->name('updatePositionGroup');

// Directorate
Route::get('/directorate', ['middleware' => 'auth', 'uses' => 'DirectorateController@index'] )->name('listDirectorate');
Route::get('/directorate/create', ['middleware' => 'auth', 'uses' => 'DirectorateController@create'] )->name('createDirectorate');
Route::post('/directorate/create', ['middleware' => 'auth', 'uses' => 'DirectorateController@store'] )->name('storeDirectorate');
Route::get('/directorate/edit/{directorate_id}', ['middleware' => 'auth', 'uses' => 'DirectorateController@edit'] )->name('editDirectorate');
Route::post('/directorate/update', ['middleware' => 'auth', 'uses' => 'DirectorateController@update'] )->name('updateDirectorate');

// Position Interest
Route::get('/positionInterest', ['uses' => 'PositionInterestController@index'] )->name('listPositionInterest');
Route::get('/positionInterest/create/{positionDescriptionId}', ['uses' => 'PositionInterestController@create'] )->name('createPositionInterest');
Route::post('/positionInterest/create', ['uses' => 'PositionInterestController@store'] )->name('storePositionInterest');
Route::get('/positionInterest/exportXLSX', ['middleware' => 'auth', 'uses' => 'PositionInterestController@exportXLSX'])->name('exportXLSXPositionInterest');

// Config
Route::get('/config/edit', ['uses' => 'ConfigController@edit'] )->name('editConfig');
Route::post('/config/update', ['uses' => 'ConfigController@update'] )->name('updateConfig');
