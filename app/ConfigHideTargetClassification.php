<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigHideTargetClassification extends Model
{
    protected $table = 'config_hide_target_classification';
    protected $fillable = ['is_hidden'];
}
