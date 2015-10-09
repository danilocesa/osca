<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'lkp_status';
	
	public static function getStatusId($status_name)
	{
		return self::where('status_name', '=', $status_name)->first()->status_id;
	}
}
