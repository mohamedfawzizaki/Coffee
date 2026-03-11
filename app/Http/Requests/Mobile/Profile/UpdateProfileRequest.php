<?php

namespace App\Http\Requests\Mobile\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
        $id = Auth::guard('mobile')->user()->id;

        return [
            'name'  => 'nullable|sometimes|string|max:255|min:3',
            'email' => 'nullable|sometimes|email|max:255|unique:customers,email,' . $id,
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Name is required'),
            'name.string' => __('Name must be a string'),
            'name.max' => __('Name must be less than 255 characters'),
            'email.required' => __('Email is required'),
            'email.email' => __('Invalid email address'),
            'email.max' => __('Email must be less than 255 characters'),
            'email.unique' => __('Email already exists'),
            'image.image' => __('File must be an image'),
            'image.mimes' => __('Image must be jpeg, png, jpg, gif, or svg'),
            'image.max' => __('Image size must be less than 2MB'),
        ];
    }
}
