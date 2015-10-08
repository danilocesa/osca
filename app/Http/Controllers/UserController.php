<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class UserController extends Controller
{
    public function getIndex($a = '_ALL')
	{
		if($a == '_ALL')
		{ //\App\User
			$user = \App\User::with('role')->orderBy ('upper(NAME)')->paginate(10);
		}else if ($a == '_NONE'){
			$user = \App\User::with('role')->where('upper(NAME)', 'like', $a.'%')
				->orderBy('upper(NAME)')->paginate(0);
		}else{
			$a = substr(strtoupper($a), 0, 1);
			$user = \App\User::with('role')->where('upper(NAME)', 'like', $a.'%')
				->orderBy('upper(NAME)')->paginate(10);
		}
		
		return view('user.index',[
			'users' => $user
		]);
	}
	
	public function getCreate()
	{
		//Add Users
		$role = \App\Role::all();
		
		return view('user.addUser',[
			'roles' => $role
		]);
	}
	
	public function postCreate(Request $request)
	{
		$messages = [
			'name.required' => 'User Name field is required.',
			'email.required' => 'User E-mail field is required.',
			'password.required' => 'Password field is required.' //,
			//'role_id.required' => 'User Role is required.'
		];
		
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
			'role_id' => 'required'
        ], $messages );
		
		if($validator->fails()){
			return redirect('user/create')
				->withErrors($validator)
				->withInput();
		}
		
		\App\User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
			'role_id' => $request['role_desc']
        ]);
		
		return redirect('user/index');
	}
	
	//edit user
	public function getEdit($id)
	{
		$user = \App\User::findOrFail($id);
		$role = \App\Role::all();
		
		return view('user.edit',[
			'users' => $user,
			'roles' => $role
		]);
	}
	
	public function putEdit()
	{
	}
	
	public function postDelete()
	{
	}
	
	public function deleteDelete()
	{
	}
}
