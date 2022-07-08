<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigPositionInterest extends Model
{
    protected $table = 'config_position_interest';
    protected $fillable = ['is_activated', 'terms_and_privacy'];
}
