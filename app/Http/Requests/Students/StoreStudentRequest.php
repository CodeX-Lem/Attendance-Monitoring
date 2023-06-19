<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'course_id' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'dob' => ['required'],
            'scholarship_type' => ['required'],
            'image' => ['max:2048'],
        ];
    }

    public function attributes()
    {
        return [
            'course_id' => 'training program',
            'dob' => 'date of birth',
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'The image must not exceed 2 MB in size.',
        ];
    }
}
