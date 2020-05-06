<?php

namespace App\Http\Middleware;

use Closure;

class MustBeShop
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
        if($request->user()->group_id == 7){
            return $next($request);
        }
        return redirect('/login');
    }
}
