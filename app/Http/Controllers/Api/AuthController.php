<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Libs\Constants;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => Constants::USER_ROLE,
        ]);
        $resetToken = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email'      => $user->email,
            'token'      => $resetToken,
            'created_at' => now(),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'      => 'Registration successful.',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'data'         => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $credential = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credential)) {
            return response()->json([
                'success' => false,
                'error'   => 'Invalid credential.',
            ], 401);
        }
        return response()->json([
            'success'      => true,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60 * 2,
        ]);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::guard()->logout();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out.'
        ]);
    }
}
