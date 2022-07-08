<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directorate extends Model
{
    protected $table = 'directorate';
    protected $fillable = ['description'];

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }
}
