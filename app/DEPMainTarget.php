<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

class DEPMainTarget extends Pivot
{
    protected $table = 'dep_maintarget';
    protected $fillable = ['position_description_id', 'maintarget_id', 'mainactivity_id', 'classification', 'activity_order', 'target_order'];
    public $timestamps = false;
    
    public function positionDescription()
    {
        return $this->belongsTo(PositionDescription::class);
    }

    public function targets()
    {
        return $this->belongsTo(MainTarget::class);
    }

    public function activities()
    {
        return $this->belongsTo(MainActivity::class);
    }

    protected static function boot()
    {
        parent::boot();
     
        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('activity_order', 'asc');
        });
    }
}
