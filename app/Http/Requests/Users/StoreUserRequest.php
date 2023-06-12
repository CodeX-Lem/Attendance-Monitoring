<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'min:6', Rule::unique('users', 'username')],
            'password' => ['required', 'min:8', 'confirmed'],
            'trainor_id' => ['required', Rule::unique('users', 'trainor_id')],
        ];
    }

    public function attributes()
    {
        return [
            'trainor_id' => 'trainor'
        ];
    }

    public function messages(): array
    {
        return [
            'trainor_id.unique' => 'This trainor has already an account',
        ];
    }
}
