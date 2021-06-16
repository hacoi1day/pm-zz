<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    private $role;

    public function __construct(Role $role) {
        $this->role = $role;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('api')->user();
        if (is_null($user->role_id)) {
            abort(401);
        }
        $role = $this->role->find($user->role_id);
        $permissions = json_decode($role->permissions);
        $router_name = $request->route()->action['as'];
        if (in_array($router_name, $permissions)) {
            return $next($request);
        }
        return abort(401);
    }
}
