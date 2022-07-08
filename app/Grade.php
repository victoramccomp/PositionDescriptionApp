<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
    protected $fillable = ['description', 'insertec_by'];    

    public function gradeCourse() 
    {
        return $this->belongsTo(GradeCourse::class, 'id', 'grade_id');
    }
}