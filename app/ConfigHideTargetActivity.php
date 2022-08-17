<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigHideTargetActivity extends Model
{
    protected $table = 'config_hide_target_activity';
    protected $fillable = ['is_hidden'];
}
