<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPosition extends Model
{
    protected $connection= 'mysqlview';

    protected $table = 'view_position';
}
