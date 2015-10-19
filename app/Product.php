<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $primaryKey = 'model_code';
	
	protected $table = 'es_item_master';
	
	public $timestamps = false;
	
	public function brandEs()
	{
		return $this->belongsTo('\App\Brand', 'brand_id_es', 'brand_id');
	}
	
	public function brandMms()
	{
		return $this->belongsTo('\App\Brand', 'brand_id_mms', 'brand_id');
	}
	
	public function variations()
	{
		return $this->hasMany('\App\Variation', 'model_code', 'model_code');
	}
	
	public function variationsView()
	{
		return $this->hasMany('\App\VariationView', 'model_code', 'model_code');
	}
	
	public function categories()
	{
		return $this->belongsToMany('\App\Subcategory', 'es_item_categories', 'model_code');
	}
	
	public function images()
	{
		return $this->hasMany('\App\Image', $primaryKey, $primaryKey);
	}
	
	// Get the primary image of the primary variation of the product. Let's roll!
	public function getPrimaryImage()
	{
		return \App\Image::where('model_code', '=', $this->model_code)
			->where('seq_no', '=', 1)
			->where('color_display_id', '=', $this->primary_color_display_id)
			->first();
	}
}
