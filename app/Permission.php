<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'lkp_permissions';
	
	protected $primaryKey = 'permission_id';
}
