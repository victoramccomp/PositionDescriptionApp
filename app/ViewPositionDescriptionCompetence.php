<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPositionDescriptionCompetence extends Model
{
    protected $connection= 'mysqlview';

    protected $table = 'view_dep_competence';
}
