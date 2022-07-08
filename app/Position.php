<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';
    protected $fillable = ['description', 'insertec_by', 'position_group_id', 'directorate_id', 'code', 'salary_grade'];

    public function positionDescription()
    {
        return $this->belongsTo(PositionDescription::class);
    }

    public function positionGroup()
    {
        return $this->belongsTo(PositionGroup::class, 'position_group_id', 'id');
    }

    public function directorate()
    {
        return $this->belongsTo(Directorate::class, 'directorate_id', 'id');
    }
}
