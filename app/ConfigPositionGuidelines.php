<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigPositionGuidelines extends Model
{
    protected $table = 'config_position_guidelines';
    protected $fillable = ['is_activated', 'guidelines'];
}
