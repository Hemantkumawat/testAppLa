<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $token = $user->createToken(env("APP_NAME"))->accessToken;

        return response()->json(["message" => __("User Registered Successfully"), "data" => compact('user', 'token')]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return response()->json(['message' => 'Invalid Email or Password'],422);
        $user = auth()->user();
        $token = $user->createToken(env("APP_NAME"))->accessToken;

        return response()->json(["message" => __("User Logged in Successfully"), "data" => compact('user', 'token')]);
    }
}
