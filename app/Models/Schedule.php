<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  
    public function User()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}