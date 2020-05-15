<?php

namespace App\Http\Middleware;

use Closure;
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
//        $this->auth->parseToken()->authenticate();

        return $next($request);
    }
}
