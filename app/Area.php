<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $fillable = ['description', 'ocde_general', 'ocde_specific', 'ocde_course'];
}
