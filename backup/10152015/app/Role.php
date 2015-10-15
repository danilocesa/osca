<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'lkp_roles';
	
	protected $primaryKey = 'role_id';
	
	public function permissions()
	{
		return $this->belongsToMany('\App\Permission', 'lkp_role_permissions');
	}
	
	public function hasPermission($permission_name)
	{
		if (is_array($permission_name)){	
			foreach($permission_name as $value){
				foreach($this->permissions as $permission){
					if ($permission->permission_name == $value)
						return true;
				}
			}
			
		} else {
			foreach($this->permissions as $permission){
				if ($permission->permission_name == $permission_name)
					return true;
			}
		}		
		
		return false;
	}
}