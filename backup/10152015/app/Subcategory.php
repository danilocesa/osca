<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'lkp_subcategory';
	
	protected $fillable = ['subcategory_id', 'subcategory_name', 'category_id'];
	
	protected $primaryKey = 'subcategory_id';
	
	public $timestamps = false;
}
