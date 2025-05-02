<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        if ($request->expectsJson()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ]);
        }

        return redirect()->route('dashboard')->withCookie(
            cookie('jwt', $token, JWTAuth::factory()->getTTL())
        );
    }

    /**
     * Log in a user.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized']);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ]);
        }

        return redirect()->route('dashboard')->withCookie(
            cookie('jwt', $token, JWTAuth::factory()->getTTL())
        );
    }

    public function logout(Request $request)
    {
        $token = $request->cookie('jwt');
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
            } catch (\Exception $e) {
                // Silently handle invalid token
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        return redirect()->route('welcome')->withCookie(cookie()->forget('jwt'));
    }

    public function me() {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // Token lifetime in seconds
        ]);
    }
}
