<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $isAuthenticated = false;
        $user = null;

        // Check for JWT token in cookie or Authorization header
        $token = $request->bearerToken() ?? $request->cookie('jwt');
        
        if ($token) {
            try {
                // Try to verify the token and get the user
                $user = JWTAuth::setToken($token)->authenticate();
                
                // If user is found and token is valid, user is authenticated
                if ($user) {
                    Auth::setUser($user);
                    $isAuthenticated = true;
                }
            } catch (JWTException $e) {
                // Token is invalid or expired, user is not authenticated
                $isAuthenticated = false;
            }
        }

        return view('welcome', compact('isAuthenticated', 'user'));
    }
} 