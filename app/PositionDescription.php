<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionDescription extends Model
{
    protected $table = 'position_description';
    protected $fillable = [
        'interviewed', 
        'position_id',
        'mission',
        'experience_time',
        'leadership_time',
        'position_id',
        'interviewer_comments',
        'company_id',
        'allowhomeoffice',
        'restrictions'
    ];
    
    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function DEPGrade()
    {
        return $this->hasMany(DEPGrade::class, 'position_description_id', 'id');
    }

    public function DEPCompetence()
    {
        return $this->hasMany(DEPCompetence::class, 'position_description_id', 'id');
    }

    public function DEPLanguage()
    {
        return $this->hasMany(DEPLanguage::class, 'position_description_id', 'id');
    }

    public function depMainTarget()
    {
        return $this->hasMany(DEPMainTarget::class, 'position_description_id', 'id');
    }

    // TRIAL
    public function gradeCourses()
    {
        return $this->belongsToMany(GradeCourse::class, 'dep_grade', 'position_description_id', 'grade_id')
            ->using(DEPGrade::class)->withPivot('status', 'requirement');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'dep_language', 'position_description_id', 'language_id')
            ->using(DEPLanguage::class)->withPivot('skill', 'level', 'requirement');
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'dep_competence', 'position_description_id', 'competence_id')
            ->using(DEPCompetence::class)->withPivot('level', 'requirement');
    }

    
    public function competenceLevel()
    {
        return $this->belongsToMany(CompetenceLevel::class, 'dep_competence', 'position_description_id', 'level')
            ->using(DEPCompetence::class)->withPivot('level', 'requirement');
    }

    public function targets()
    {
        return $this->belongsToMany(MainTarget::class, 'dep_maintarget', 'position_description_id', 'maintarget_id')
            ->using(DEPMainTarget::class)->withPivot('maintarget_id', 'mainactivity_id', 'classification', 'activity_order', 'target_order');
    }

    public function activities()
    {
        return $this->belongsToMany(MainActivity::class, 'dep_maintarget', 'position_description_id', 'mainactivity_id')
            ->using(DEPMainTarget::class)->withPivot('maintarget_id', 'mainactivity_id');
    }
}