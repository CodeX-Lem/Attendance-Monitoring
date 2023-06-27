<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProfileRequest extends FormRequest
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
            'image' => ['max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'The image must not exceed 2 MB in size.',
        ];
    }
}
