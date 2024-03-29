<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'overall_score' => 0,
        ]);

        $token = $user->createToken('bugbooktoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json([
            'data' => $response
        ], $status = HttpResponse::HTTP_CREATED);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Email check
        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials.'
            ], 401);
        }

        $token = $user->createToken('bugbooktoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json([
            'data' => $response
        ], $status = HttpResponse::HTTP_CREATED);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out.'
        ];

    }
}
