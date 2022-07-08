<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $table = 'competence';
    protected $fillable = ['description', 'insertec_by'];
    
    public function positionDescription()
    {
        return $this->belongsToMany(PositionDescription::class, 'dep_competence', 'competence_id', 'position_description_id');
    }

    public function competenceType()
    {
        return $this->belongsTo(CompetenceType::class, 'competence_type_id', 'id');
    }
}
