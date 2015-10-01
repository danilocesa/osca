<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    protected $table = 'lkp_world';
	
	protected $fillable = ['world_id', 'world_name'];
	
	protected $primaryKey = 'world_id';
	
	public $timestamps = false;
	
	public function categories()
	{
		return $this->hasMany('App\Category', 'world_id', 'world_id');
	}
}