<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $result = $this->authService->login($credentials);

        if (! $result) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($result['token'], $result['user']);
    }

    public function register(AuthRequest $request)
    {
        $data = $request->validated();
        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists',
            ], 409);
        }

        $result = $this->authService->createUser($data);

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $result['token'],
            'user' => $result['user'],
        ], 201);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $result = $this->authService->refresh();

        return $this->respondWithToken($result['token'], $result['user']);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
