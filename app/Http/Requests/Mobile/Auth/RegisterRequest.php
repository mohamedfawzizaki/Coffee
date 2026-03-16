<?php

namespace App\Http\Requests\Mobile\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name'     => 'required|min:3|max:255',
            'phone'    => 'required|min:10|max:15|unique:customers,phone',
            'email'    => 'nullable|email|unique:customers,email',
            'birthday' => 'nullable|date_format:Y-m-d|before:' . now()->subYears(7)->toDateString(),
        ];

    }

    public function messages(): array
    {
        return [
            'birthday.before' => __('You Should Be At Least 7 Years Old'),
            'birthday.required' => __('Birthday is required'),
            'birthday.date_format' => __('Invalid birthday format'),
            'name.required' => __('Name is required'),
            'name.min' => __('Name must be at least 3 characters'),
            'name.max' => __('Name must be less than 255 characters'),
            'phone.required' => __('Phone is required'),
            'phone.min' => __('Phone must be at least 10 characters'),
            'phone.max' => __('Phone must be less than 15 characters'),
            'phone.unique' => __('Phone already exists'),
            'email.email' => __('Invalid email address'),
            'email.unique' => __('Email already exists'),
        ];
    }
}
