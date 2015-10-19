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
			$user = \App\User::with('role')->where('status', '=', '6')
							->orderBy ('upper(NAME)')->paginate(10);
		//}else if ($a == '_NONE'){
		//	$user = \App\User::with('role')->where('upper(NAME)', 'like', $a.'%')
		//		->where('status', '=', '6')
		//		->orderBy('upper(NAME)')->paginate(0);
		}else{
			$a = substr(strtoupper($a), 0, 1);
			$user = \App\User::with('role')->where('upper(NAME)', 'like', $a.'%')
				->where('status', '=', '6')
				->orderBy('upper(NAME)')->paginate(10);
		}
		
		return view('user.index',[
			'users' => $user
		]);
	}
	
	public function getSearch()
	{	
		if($_GET['user_search']==''){
			$user = \App\User::with('role')
								->orderBy('upper(NAME)')
								->paginate(10);						
		}else{
			$user = \App\User::with('role')
			    ->where('upper(NAME)','like','%'.strtoupper($_GET['user_search']).'%')
				->where('status','=','6')
				->orderBy('UPPER(NAME)')->paginate(10);
		}
		
		return view('user.index',[
			'users'	=> $user
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
			//'name.unique'	=> 'User Name may be existing or previously deleted.',
			'email.required' => 'User E-mail field is required.',
			'password.required' => 'Password field is required.',
			//'password_confirmed.same' => 'Password mismatch. Please try again.',
			'role_desc.required' => 'Role is required.'
		];
		
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',   //Username must be unique
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
			'role_desc' => 'required'
        ], $messages );		
		
		$username='';
		
		$validator->after(function($validator){
			$data = $validator->getData();
			$username = $data['name'];
			
			//Username must be checked if Active or not
			
		});
		
		if($validator->fails()){
			// return redirect('user/create')
				// ->withErrors($validator)
				// ->withInput();				
				return dump($username);
		}
		
		\App\User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
			'role_id' => $request['role_desc'],
			'status' => 6
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
	
	public function putEdit(Request $request, $id)
	{
		$messages = [
			'name.required' => 'User Name is required.',
			'email.required' => 'User E-mail is required.',
			'password.required' => 'Password is required.',
			'role_desc.required' => 'Role is required.'
		];
		
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
			'role_desc' => 'required'
        ], $messages );
		
		if($validator->fails()){
			return redirect('user/create')
				->withErrors($validator)
				->withInput();
		}else {
			$user = \App\User::find($id);
			$user->name = $request->get('name');
			$user->email = $request->get('email');
			$user->password = $request->get('password');
			$user->role_id = $request->get('role_desc');
			$user->update();
		
			return redirect('user');
		
		}
	}
	
	public function postDelete(Request $request)
	{
		$checks = array_get($request->all(), 'check');
		
		if(sizeof($checks)==0)
		{
			return redirect('user');
		}else{
			$data = \App\User::wherein('id', $checks)->get();
			
			//return view('user.delete',[
				//'detail' => $data
			//]);
			return redirect('user');
		}
	}
	
	public function deleteDelete(Request $request)
	{
		$data = array_get($request->all(), 'delete_users');
		$delusers = array_get($request->all(), 'deluser');
		
		if($data == 'YES')
		{
			foreach($delusers as $dat)
			{
				$del_object = \App\User::find($dat);
				$del_object->status = 7;
				$del_object->last_update_date = \DB::raw('SYSDATE');
				$del_object->last_update_by = \Auth::user()->id;
				$del_object->update();
			}
		}
		return redirect('user');
	}
}
