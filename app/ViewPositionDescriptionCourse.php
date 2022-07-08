<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPositionDescriptionCourse extends Model
{
    protected $connection= 'mysqlview';

    protected $table = 'view_dep_grade';
}
