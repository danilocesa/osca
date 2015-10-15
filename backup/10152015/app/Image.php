<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'ES_IMAGES';
	
	protected $primaryKey = 'product_id';
	
	public $timestamps = false;
	
	protected $fillable = ['product_id', 'image_full_path', 'seq_no', 'filename'];
}
