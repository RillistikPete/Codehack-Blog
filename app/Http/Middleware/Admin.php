<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        // include use Illuminate\Support\Facades\Auth;

        //this function isn't possible without the function in User.php model isAdmin()
        // if(Auth::check()){
        //     if(Auth::user()->isAdmin()){

        //         return $next($request);

        //     }
        // }
        // return redirect('/');
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
