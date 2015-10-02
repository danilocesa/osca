<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $primaryKey = 'product_id';
	
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
		return $this->hasMany('\App\ProductVariation', 'model_code', 'model_code');
	}
}
