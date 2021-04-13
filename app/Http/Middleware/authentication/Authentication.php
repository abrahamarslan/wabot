<?php

namespace App\Http\Middleware\authentication;

use Sentinel;
use Closure;
use Illuminate\Http\Request;

class Authentication
{
    protected $exceptRoutes = [
        'authentication.login.index',
        'authentication.login.create',
        'authentication.login.getLogout',
        'authentication.registration.index',
        'authentication.registration.create',
        'authentication.recovery.index',
        'authentication.recovery.create',
        'authentication.reset.index',
        'authentication.reset.create',
        'authentication.activation.index',
        'authentication.activation.create'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        if(!in_array($route, $this->exceptRoutes)) {
            if(!Sentinel::check())
            {
                return redirect()->route('authentication.login.index')->with('error', 'You must be logged in!');
            }
            elseif(!Sentinel::inRole('users')){
                return redirect()->route('authentication.login.index')->with('error', 'You are not authorized for this operation.');
            }
        }
        return $next($request);
    }
}
