<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
        $userId = $this->route('user') ?? $this->route('customer');
        return [
            'name'     => 'required|string|max:100',
            'email'    => ['required', 'email', 'max:120', Rule::unique('users')->ignore($userId)],
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => $this->isMethod('post') ? 'required|string|min:6|confirmed' : 'nullable|string|min:6|confirmed',
            'role'     => 'nullable|integer',
            'status'   => 'nullable|integer',
        ];
    }
}
