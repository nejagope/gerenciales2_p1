<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
	{
	  return $this->belongsTo('App\User');
	}
	
	public function products()
	{
	  return $this->belongsToMany('App\Product');
	}
	
	public function shippings()
	{
	  return $this->hasMany('App\Shipping');
	}
	
	public function devolutions()
	{
	  return $this->hasMany('App\Devolution');
	}
	
	public function gifts()
	{
	  return $this->belongsToMany('App\Gift');
	}
	
	public function receptions()
	{
	  return $this->hasMany('App\Reception');
	}
}
