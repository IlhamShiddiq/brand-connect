<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $isAuthenticated = auth()->attempt($request->only('email', 'password'));
        if ($isAuthenticated) {
            $user = auth()->user();
            return response()->json([
                'status' => 200,
                'message' => 'Login success',
                'data' => [
                    'token' => $user->createToken('authToken')->plainTextToken,
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }
    }
}
