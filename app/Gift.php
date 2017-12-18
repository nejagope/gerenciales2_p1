<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    public function user()
	{
	  return $this->belongsTo('App\User');
	}
	
	public function orders()
	{
	  return $this->belongsToMany('App\Order');
	}
}
