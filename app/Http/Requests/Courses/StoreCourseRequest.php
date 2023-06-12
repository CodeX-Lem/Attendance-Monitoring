<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
            'course' => ['required', 'max:255', Rule::unique('courses', 'course')],
            'trainor_id' => ['required', 'unique:courses']
        ];
    }

    public function attributes()
    {
        return [
            'course' => 'course',
            'trainor_id' => 'trainor'
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'course.required' => 'The course field is required',
    //         'course.max' => 'The course length must not exceed 255 characters',
    //         'course.unique' => 'The course already exist',
    //     ];
    // }
}
