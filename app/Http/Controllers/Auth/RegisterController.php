<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Libs\Constants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],422);
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => Constants::USER_ROLE,
            'status'   => Constants::STATUS_ACTIVE
        ]);
        return response()->json([
            'success'   => true,
            'message'  => 'Registered successfully.',
            'redirect' => route('login')
        ],201);
    }
}
