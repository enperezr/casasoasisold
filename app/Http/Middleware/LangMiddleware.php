<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Config;

class LangMiddleware
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
        $parts = explode('/',$request->path());
        if(in_array($parts[0], Config::get('app.languages'))){
            App::setLocale($parts[0]);
        }
        return $next($request);
    }
}
