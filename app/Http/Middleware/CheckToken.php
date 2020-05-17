<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckToken extends BaseMiddleware
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
        //是否携带 token, 抛出异常:UnauthorizedHttpException
//        $this->checkForToken($request);

        //token是否有效, 抛出异常:TokenInvalidException
        //$user = $this->auth->parseToken()->authenticate();

        /*$url = substr($request->path(), 3);
        $role = $user->role;
        if(!$role) {
            echo '没有角色';
        }
        Permission::where('url', $url)->first();*/

        return $next($request);
    }
}
