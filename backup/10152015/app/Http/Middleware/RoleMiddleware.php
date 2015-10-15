<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		// Apply route access here based on permissions given on the user's role

		// User Management
		if ($request->is('user*')){
			if (! $request->user()->role->hasPermission("CAN_MANAGE_USERS"))
				$this->warn();
		}
		
		return $next($request);
    }
	
	private function warn()
	{
		abort(403, 'You do not have permission to access this resource. Your IP address is tracked by our system. We know who you are. I will find you and I will kill you.');
	}
}
