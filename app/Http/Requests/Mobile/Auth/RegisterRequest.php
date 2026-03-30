<?php

namespace App\Http\Requests\Mobile\Auth;

use App\Rules\UniquePhone;
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
            'phone'    => ['required', 'string', 'size:9', new UniquePhone('customers', 'phone')],
            'email'    => 'nullable|email|unique:customers,email',
            'birthday' => 'nullable|date_format:Y-m-d|before:' . now()->subYears(7)->toDateString(),
            'referral_code' => 'nullable',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('phone')) {
            $this->merge([
                'phone' => normalizePhone($this->phone),
            ]);
        }
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
            'phone.size' => __('Phone must be exactly 9 digits (format: 5xxxxxxxx)'),
            'email.email' => __('Invalid email address'),
            'email.unique' => __('Email already exists'),
        ];
    }
}
