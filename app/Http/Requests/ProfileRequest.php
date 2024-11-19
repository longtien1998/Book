<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class ProfileRequest extends FormRequest
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
        $user = Auth::user();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'phone' => 'nullable|string|min:10|max:10',
            'address' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.min' => 'Số điện thoại không được dưới 10 số',
            'phone.max' => 'Số điện thoại không được vượt quá 10 số'
        ];
    }
}
