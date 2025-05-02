<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class JwtWebMiddleware
{
    /**
     * Handle an incoming request and check for a valid JWT.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Look for the JWT in the Authorization header (e.g., "Bearer token") or a cookie named 'jwt'
            $token = $request->bearerToken() ?? $request->cookie('jwt');

            // If no token is found, redirect to the login page with an error
            if (!$token) {
                return redirect()->guest(route('login'))->withErrors(['error' => 'Unauthorized']);
                // redirect()->guest() sends unauthenticated users to login
                // withErrors() adds a message to display
            }

            // Try to verify the token and get the user
            $user = JWTAuth::setToken($token)->authenticate();
            // setToken() sets the token to check
            // authenticate() checks if it’s valid and returns the user

            // If no user is found (e.g., token is invalid), redirect to login
            if (!$user) {
                return redirect()->guest(route('login'))->withErrors(['error' => 'Unauthorized']);
            }

            // Set the user as logged in for this request
            Auth::setUser($user);
            // This lets Laravel know who’s authenticated

        } catch (JWTException $e) {
            // If the token is expired or invalid, catch the error and redirect
            return redirect()->guest(route('login'))->withErrors(['error' => 'Invalid or expired token']);
            // JWTException happens if the token can’t be read or verified
        }

        // If everything checks out, let the request continue to the route
        return $next($request);
    }
}
