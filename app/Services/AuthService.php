<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function createUser(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_picture' => $data['profile_picture'] ?? null,
        ]);

        $token = Auth::guard('api')->login($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return null;
        }

        return [
            'user' => Auth::guard('api')->user(),
            'token' => $token,
        ];
    }

    public function logout()
    {
        Auth::guard('api')->logout();
    }

    public function refresh()
    {
        return [
            'user' => Auth::guard('api')->user(),
            'token' => Auth::guard('api')->refresh(),
        ];
    }
}
