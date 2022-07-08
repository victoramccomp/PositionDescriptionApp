<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $fillable = ['role', 'screen'];

    
    public function user()
    {
        return $this->belongsToMany(Users::class, 'user_role')
            ->using(UserRole::class);
    }
}
