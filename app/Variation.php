<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $primaryKey = 'product_id';
	
	protected $table = 'es_item_variation';
	
	public $timestamps = false;
	
	public function status()
	{
		return $this->hasOne('\App\Status', 'status_id', 'status_id');
	}
	
	public function color()
	{
		return $this->hasOne('\App\Color', 'color_id', 'color_id');
	}
	
	public function size()
	{
		return $this->hasOne('\App\Size', 'size_id', 'size_id');
	}
	
	public function variationView()
	{
		return $this->hasOne('\App\VariationView', 'product_id', 'product_id');
	}

	
	public function getPrimaryImage()
	{
		if (is_null($this->color))
			return null;
			
		return \App\Image::where('model_code', '=', $this->model_code)
			->where('seq_no', '=', 1)
			->where('color_display_id', '=', $this->color->color_display_id)
			->first();
	}
}