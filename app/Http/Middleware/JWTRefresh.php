<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JWTRefresh
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($token = JWTAuth::getToken()) {
            $newToken = JWTAuth::refresh($token);
            $response->headers->set('Authorization', 'Bearer ' . $newToken);
        }

        return $response;
    }
}
