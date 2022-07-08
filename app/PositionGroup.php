<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionGroup extends Model
{
    protected $table = 'position_group';
    protected $fillable = ['description'];

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }
}
