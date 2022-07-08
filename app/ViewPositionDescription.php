<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPositionDescription extends Model
{
    protected $connection= 'mysqlview';

    protected $table = 'view_dep';
}
