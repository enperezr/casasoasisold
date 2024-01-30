<?php

namespace App\Http\Middleware;

use App\Rol;
use Closure;


class HasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String $role, name of the role
     * @return mixed
     */
    public function handle($request, Closure $next, $rols)
    {
        $rols = Rol::wherein('name',explode("|",$rols))->get();
        if (!in_array($request->user()->rol->id, $rols->pluck('id')->all())) {
            abort(403);
        }
        return $next($request);
    }
}
