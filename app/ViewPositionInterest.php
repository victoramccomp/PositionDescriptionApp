<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPositionInterest extends Model
{
    protected $connection= 'mysqlview';

    protected $table = 'view_user_position_interest';
}
