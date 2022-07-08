<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';
    protected $fillable = ['description', 'inserted_by'];

    public function positionDescription()
    {
        return $this->belongsToMany(PositionDescription::class, 'dep_language', 'language_id', 'position_description_id')
            ->using(DEPLanguage::class);
    }

    public function DEPLanguage()
    {
        return $this->hasMany(DEPLanguage::class, 'id', 'language_id');
    }

}
