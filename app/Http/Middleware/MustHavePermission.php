<?php

namespace App\Http\Middleware;

use Closure;
use App\Library\CustomDesignHelper as CD;

class MustHavePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $function)
    {
        /*
        if(auth()->check()){
            $permissions = auth()->user()->group;
            if(count($permissions->roles)>0) {
                foreach ($permissions->roles as $p) {
                    if ($p->function == $function && $p->permission == 1) {
                        return $next($request);
                    }
                }
            }
        }
        */

        if(CD::checkPermission($function)){
            return $next($request);
        }
        return redirect('/not-allowed');
    }
}
