<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
	
	protected $redirectPath = '/product';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {	
		return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }
	
	//added
	private function lockoutTime() 
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 60;
    }
	
	//added
	protected function maxLoginAttempts()
	{
		return property_exists($this, 'maxLoginAttempts') ? $this->maxLoginAttempts : 3;
	}
	
	//test
	public function postLogin(Request $request)
    {	
		//added
		// This section is the only change
		$user = \App\User::select('status')->where('email', '=', $request->email)
			->first();
		
		if($user === null)
		{
			return redirect($this->loginPath()) // Change this to redirect elsewhere
                   ->withInput($request->only('email', 'remember'))
                   ->withErrors([
                       'active' => 'These credentials do not match our records.'
                   ]);
		}
		
		if($user->status != 6)
		{
			return redirect($this->loginPath()) // Change this to redirect elsewhere
                   ->withInput($request->only('email', 'remember'))
                   ->withErrors([
                       'active' => 'You must be active to login.'
                   ]);
		}
		//end added
		
		$this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
		
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
	//end test
	
	// Override user registration
	public function getRegister()
	{
		return redirect('/');
	}

	public function postRegister()
	{
		return redirect('/');
	}
}
