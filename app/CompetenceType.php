<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenceType extends Model
{
    protected $table = 'competence_type';
    protected $fillable = ['description'];
    
    public function competenceLevel()
    {
        return $this->belongsTo(CompetenceLevel::class, 'id', 'competence_type_id');
    }
}