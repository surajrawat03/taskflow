<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Check for JWT token in cookie or Authorization header
        $token = $request->bearerToken() ?? $request->cookie('jwt');
        
        if ($token) {
            try {
                // Try to verify the token and get the user
                $user = JWTAuth::setToken($token)->authenticate();
                
                // If user is found and token is valid, redirect to dashboard
                if ($user) {
                    Auth::setUser($user);
                    return redirect(RouteServiceProvider::HOME);
                }
            } catch (JWTException $e) {
                // Token is invalid or expired, continue to the requested page
                // Clear any invalid token
                if ($request->cookie('jwt')) {
                    return redirect()->route('login')->withCookie(cookie()->forget('jwt'));
                }
            }
        }

        // Also check Laravel's default authentication as fallback
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
