<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionInterest extends Model
{
    protected $table = 'position_interest';
    protected $fillable = ['name', 'document_type', 'document_info', 'dep_id'];

    public function positionDescription()
    {
        return $this->belongsTo(PositionDescription::class, 'dep_id', 'id');
    }
}
