<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenceLevel extends Model
{
    protected $table = 'competence_level';
    protected $fillable = ['description', 'insertec_by', 'competence_type_id'];
    
    public function positionDescription()
    {
        return $this->belongsToMany(PositionDescription::class, 'dep_competence', 'level', 'position_description_id');
    }

    public function competenceType()
    {
        return $this->belongsTo(CompetenceType::class, 'competence_type_id', 'id');
    }
}