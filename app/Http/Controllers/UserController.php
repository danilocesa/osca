<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DateTime;
use Carbon;

class UserController extends Controller
{
    public function getIndex($a = '_ALL')
	{
		if($a == '_ALL')
		{ //\App\User
			$user = \App\User::with('role')->where('status', '=', '6')
							->where('id','!=','1')
							->orderBy ('upper(NAME)');
		}else{
			$a = substr(strtoupper($a), 0, 1);
			$user = \App\User::with('role')->where('upper(NAME)', 'like', $a.'%')
				->where('status', '=', '6')
				->where('id','!=','1')
				->orderBy('upper(NAME)');
		}
		
		return view('user.index',[
			'users' => $user->paginate(10)
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
	//Modified the validation
		// Added after validation
		// Email validation under AFTER_VALIDATION block
		// - 10/20/2015 xiphi
	
		$messages = [
			'name.required' => 'User Name field is required.',
			'email.required' => 'User E-mail field is required.',
			'password.required' => 'Password field is required.',
			'password_confirmation.same' => 'Password mismatch. Please try again.',
			'password_confirmation.required' => 'Confirm Password is required',
			'role_desc.required' => 'Role is required.'
		];
		
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
			'password_confirmation'=>'required|same:password',
			'role_desc' => 'required'
        ], $messages );		
		
		//AFTER_VALIDATION
		$validator->after(function($validator){
			$data = $validator->getData();
			$email = $data['email'];			
													
			//Username must be unique and not previously entered
			$userCount=\App\User::where('upper(trim(email))','like',strtoupper(trim($email)))
						->where('status','=','7')						
						->count()
			;
			
			if($userCount>0){
				$validator->errors()->add('email','Email was previously deleted');
			}else{
				$userCount=\App\User::where('upper(trim(email))','like',strtoupper(trim($email)))
						->where('status','=','6')						
						->count()
						;
				
				if($userCount>0){
					$validator->errors()->add('email','Email unavailable');
				}
			}
		});
		
		if($validator->fails()){
			return redirect('user/create')
				->withErrors($validator)
				->withInput();								
		}else{					
			$user = new \App\User();						
			$user->name 			= trim($request['name']);
			$user->email 			= trim($request['email']);
			$user->password 		= bcrypt($request['password']);
			$user->role_id 			= $request['role_desc'];
			$user->status 			= 6;
			$user->last_update_date = \DB::raw('SYSDATE');
			$user->last_update_by 	= \Auth::user()->id;	
			$user->save();
			
			return redirect('user/index');
		}   
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
	//Modified the following validations
		// Email has been removed while editing. User may only view the inputted email.
		// - 10/20/2015 xiphi
	
		$messages = [
			'name.required' 					=> 'User Name field is required.',
			'password.required' 				=> 'Password field is required.',
			'password_confirmation.same' 		=> 'Password mismatch. Please try again.',
			'password_confirmation.required' 	=> 'Confirm Password is required',
			'role_desc.required' 				=> 'Role is required.'
		];
		
		$validator = Validator::make($request->all(), [           

			'name' 					=> 'required|max:255',   
            'password' 				=> 'required|min:6',
			'password_confirmation'	=> 'required|same:password',
			'role_desc' 			=> 'required'
        ], $messages );
		
		
		if($validator->fails()){
			return redirect('user/edit/'.$id)
				->withErrors($validator)
				->withInput();
		}else {
			$user = \App\User::find($id);
			$user->name 			= trim($request['name']);
			$user->password 		= bcrypt($request['password']);
			$user->role_id 			= $request['role_desc'];
			$user->last_update_date = \DB::raw('SYSDATE');
			$user->last_update_by 	= \Auth::user()->id;						
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
