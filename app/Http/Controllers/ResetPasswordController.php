<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; 
use App\Models\ResetPassword;
use App\Models\User;
use App\Mail\resetPasswordEmail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * reset password
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $token = Str::random(64);
        $email = $request->email;

        ResetPassword::create([
            'email' => $email,
            'token' => $token,
        ]);

        // Send email
        Mail::to($email)->send(new resetPasswordEmail($email, $token));
        return back()->with('success', 'If your email address exists in our system, a password reset link has been sent. Please check your inbox.');
    }

    public function passwordReset($token)
    {
        $tokenData = ResetPassword::where('token', $token)->first();

        if (!$tokenData) {
            return abort(404, 'invalid token');
         }

        return view('auth.create-new-password', ['token' => $token]);
    }

    public function updatePassword(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|same:password_confirmation',
            'password_confirmation' => 'required',
        ]);

        $tokenData = ResetPassword::where('token', $token)->first();

        if (!$tokenData) {
            return abort(404, 'invalid token');
         }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return abort(404, "Can't find user. Make sure email is correct.");
        }

        $user->password = Hash::make($request->password);
        $user->save();
        // Delete the reset token after successful password update
        $tokenData->delete();
        return redirect()->route('login')->with('status', 'Password updated successfully. You can now log in.');
    }
}
