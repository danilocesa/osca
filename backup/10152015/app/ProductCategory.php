<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'es_item_categories';
	
	protected $primaryKey = 'model_code'; // it's actually model_code and subcategory_id, but Laravel does not support composite keys, and it's working, so let's have a coffee shall we?
	
	public $timestamps = false;
	
	protected $fillable = ['model_code', 'subcategory_id'];
}
