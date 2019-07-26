<?php

namespace App\Http\Middleware;

use Closure;

class VerifyIsAdmin
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
    if(!auth()->user()->isAdmin()){

        session()->flash('error','You do not have permission to access that page');
        return redirect(route('home'));
    }

        return $next($request);
    }
}
