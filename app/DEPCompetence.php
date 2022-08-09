<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DEPCompetence extends Pivot
{
    protected $table = 'dep_competence';
    protected $fillable = ['position_description_id', 'competence_id', 'level', 'requirement'];
    public $timestamps = false;
    
    public function positionDescription()
    {
        return $this->belongsTo(PositionDescription::class);
    }

    public function competenceLevel()
    {
        return $this->belongsTo(CompetenceLevel::class, 'level', 'id');
    }

    public function competence()
    {
        return $this->hasMany(Competence::class, 'competence_id', 'id')
            ->orderBy('id', 'asc');
    }
}
