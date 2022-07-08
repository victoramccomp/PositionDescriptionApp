<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DEPGrade extends Pivot
{
    protected $table = 'dep_grade';
    protected $fillable = ['position_description_id', 'grade_id', 'status', 'requirement'];
    public $timestamps = false;
    
    public function positionDescription()
    {
        return $this->belongsTo(PositionDescription::class, 'position_description_id', 'id');
    }
}
