<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SermProject extends Model
{
    protected $table = 'serm_project'; 
	
	public function userInfo()
    {
        return $this->hasOne('App\User','id','user');
    }
}
