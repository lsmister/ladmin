<?php

namespace App\Http\Middleware;

use Closure;

class JsonCors
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
        $data = $next($request);
        if ($data instanceof \Illuminate\Http\JsonResponse) {
            $data->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            // 下面是跨域控制代码
            /*$data->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Credentials' => 'true',
            ]);*/
        }

        return $data;
    }
}
