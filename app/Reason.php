<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    public function devolutions()
	{
	  return $this->hasMany('App\Devolution');
	}
}
