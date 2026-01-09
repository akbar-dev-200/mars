<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('login')) {
            return [
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8|max:255',
            ];
        }

        return [
            'first_name' => 'required|min:1|max:255|string',
            'last_name' => 'required|min:1|max:255|string',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        if ($this->routeIs('login')) {
            return [
                'email.required' => 'Email is required to login.',
                'email.email' => 'Please enter a valid email address.',
                'password.required' => 'Password is required to login.',
                'password.min' => 'Password must be at least 8 characters.',
            ];
        }

        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'profile_picture.image' => 'Profile picture must be an image.',
            'profile_picture.mimes' => 'Allowed formats: jpg, jpeg, png, webp.',
            'profile_picture.max' => 'Profile picture must not exceed 2MB.',
        ];
    }
}
