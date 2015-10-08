<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'LKP_BRAND';
	public $timestamps = false;
	protected $primaryKey = 'brand_id';
}
