<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainTarget extends Model
{
    protected $table = 'main_target';
    public $timestamps = false;

    public function positionDescription()
    {
        return $this->belongsToMany(PositionDescription::class, 'dep_maintarget', 'maintarget_id', 'position_description_id')
            ->using(DEPMainTarget::class);
    }
}
