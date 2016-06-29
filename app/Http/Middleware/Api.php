<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use JWTAuth;

class Api
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
        if (!$request->has("access_token")) {
            return self::throwError('Please provide an access token');
        }
        $accessToken = $request->get("access_token");

        try {
            JWTAuth::setToken($accessToken);
            $user = JWTAuth::toUser();
        } catch (\Throwable $e) {
            return self::throwError("Invalid Access Token provided");
        }

        if (!$user) {
            return self::throwError("Invalid Access Token provided");
        }

        $request->user = $user;
        return $next($request);
    }

    public static function throwError($message, $errorCode = 403)
    {
        return Response::json([
            'error' => $message,
            'success' => false,
        ], $errorCode);
    }
}
