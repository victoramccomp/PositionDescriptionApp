<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeCourse extends Model
{
    protected $table = 'grade_course';
    protected $fillable = ['description', 'inserted_by', 'grade_id', 'area_id'];

    public function positionDescription()
    {
        return $this->belongsToMany(PositionDescription::class, 'dep_grade', 'grade_id', 'position_description_id')
            ->using(DEPGrade::class);
    }

    public function DEPGrade()
    {
        return $this->hasMany(DEPGrade::class, 'id', 'grade_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}