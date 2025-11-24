<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TokenRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());

        return response()->json([
            'accessToken' => $user->createToken('authToken')->accessToken,
        ], 201);
    }

    public function token(TokenRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        $user->tokens()->each(function (Token $token) {
            $token->revoke();
        });

        return response()->json([
            'accessToken' => $user->createToken('authToken')->accessToken,
        ]);
    }
}
