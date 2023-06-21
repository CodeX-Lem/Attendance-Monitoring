<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'dob' => ['required'],
            'scholarship_type' => ['required'],
            'training_completed' => ['required'],
            'barangay' => ['required'],
            'nationality' => ['required'],
            'district' => ['required'],
            'city' => ['required'],
            'province' => ['required'],
            'civil_status' => ['required'],
            'gender' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'dob' => 'date of birth',
        ];
    }
}
