<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainActivity extends Model
{
    protected $table = 'main_activity';
    public $timestamps = false;

    public function positionDescription()
    {
        return $this->belongsToMany(PositionDescription::class, 'dep_maintarget', 'mainactivity_id', 'position_description_id')
            ->using(DEPMainTarget::class);
    }
}
