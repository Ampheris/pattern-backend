<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Do not check user authentication for requests to authenticate
        if ($request->routeIs('login.*')) {
            return $next($request);
        }

        // User has an bearer token
        if ($request->bearerToken()) {
            $access_token = $request->bearerToken();
        } else if ($request->hasHeader('Authorization')) {
            $access_token = $request->header('Authorization');
            $token_arr = explode(' ', $access_token);
            $access_token = $token_arr[1];
        } else {
            return response('Unauthorized, has no token', 401);
        }


        try {
            // Does a user exists with this access token?
            $user = DB::table('users')->where('access_token', $access_token)->first();
            // Is the access token valid?
            if ($user->token_expires < Carbon::now()) {
                return response('Unauthorized, failed to find user', 401);
            }

            // Load the user
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

        } catch (\Throwable $e) {
            return response('Unauthorized, everything is wrong', 401);
        }

        return $next($request);
    }
}
