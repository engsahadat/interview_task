<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ],422);
        }
        $credential = $request->only('email', 'password');

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return response()->json([
                'success'   => true,
                'message'   => 'Successfully Logged In.',
                'redirect'  => route('dashboard')
            ],200);
        }
        return response()->json([
            'success' => false,
            'error'   => 'Invalid credential.',
        ],401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
