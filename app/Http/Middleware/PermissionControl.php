<?php

namespace App\Http\Middleware;

use App\UserPermission;
use Closure;
use Illuminate\Support\Facades\Config;

class PermissionControl
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
        // tarayicida gorunen ismin / isaretini sildik /user => user
        // prefix e gore ayiriyoruz(prefix => www.tugrandemirel.com/urun)
        $prefix = str_replace('/', '', request()->route()->getPrefix());
        $index = array_search($prefix, Config::get('app.permission'));
        if (!UserPermission::getMyControl($index))
            return redirect('/');

        return $next($request);
    }
}
