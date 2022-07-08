<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPositionDescriptionTargetActivity extends Model
{
    protected $connection= 'mysqlview';

    protected $table = 'view_dep_maintarget_activity';
}
