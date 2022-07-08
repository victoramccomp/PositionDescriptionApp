<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DEPLanguage extends Pivot
{
    protected $table = 'dep_language';
    protected $fillable = ['position_description_id', 'language_id'];
    public $timestamps = false;
    
    public function positionDescription()
    {
        return $this->belongsTo(PositionDescription::class, 'position_description_id', 'id');
    }

    public function Language()
    {
        return $this->belongsTo(Language::class);
    }
}
