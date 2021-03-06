<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Devolution extends Model
{
	public function order()
	{
	  return $this->belongsTo('App\Order');
	}
	
	public function reason()
	{
	  return $this->belongsTo('App\Reason');
	}
	
	public function product()
	{
	  return $this->belongsTo('App\Product');
	}
}
