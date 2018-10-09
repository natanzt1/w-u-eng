<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Role;
use URL;
use App\UserInfo;
use DB;

class RoleAuth
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
        $route = DB::table('rbac_submenu_mapping')
            ->join('rbac_route2', 'rbac_route2.route_id', '=', 'rbac_submenu_mapping.route_id')
            ->where([
                'role_id'       => session()->get('currentRole')->brokerrole_id,
                'nama_route'    => \Request::route()->getName(),
            ])->get()->first();

        if (empty($route)) {
            return response()->view('errors.403');
        }

        return $next($request);
    }
}
