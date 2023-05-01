<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $create = User::create($request->validated());
        return apiResponseSuccess($create);
    }

    public function login(LoginRequest $request){
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return apiResponseFailed('Sorry, Invalid Credentials.');
            }

            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return apiResponseSuccess(['token' => $token]);
        } catch (\Throwable $th) {
            return apiResponseFailed('Sorry, Invalid Credentials.');
        }
    }

    public function logout(Request $request){
        try {
            Auth::user()->currentAccessToken()->delete();
            return apiResponseSuccess('Logged out.');
        } catch (\Throwable $th) {
            return apiResponseFailed('Sorry, Invalid Credentials.');
        }
    }
}
