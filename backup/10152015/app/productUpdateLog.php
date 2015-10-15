<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productUpdateLog extends Model
{
    //
	protected $table = 'es_item_master_log';
	
	public $timestamps = false;
	
	public function user()
	{
		return $this->hasOne('\App\User', 'id', 'update_by');
	}
}
