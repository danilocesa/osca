<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'lkp_category';
	
	protected $fillable = ['category_id', 'category_name', 'world_id'];
	
	protected $primaryKey = 'category_id';
	
	public $timestamps = false;
	
	public function subcategories()
	{
		return $this->hasMany('App\Subcategory', 'category_id', 'category_id');
	}
}
