<?php

namespace App\Http\Requests\Mobile\Gift;

use Illuminate\Foundation\Http\FormRequest;

class GiftStoreRequest extends FormRequest
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
            'phone'   => 'required|string|max:255',
            'message' => 'nullable|string|max:255',
            'amount'  => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => __('Phone is required'),
            'phone.string' => __('Phone must be a string'),
            'phone.max' => __('Phone must be less than 255 characters'),
            'message.string' => __('Message must be a string'),
            'message.max' => __('Message must be less than 255 characters'),
            'amount.required' => __('Amount is required'),
            'amount.numeric' => __('Amount must be a number'),
            'amount.min' => __('Amount must be greater than 0'),
        ];
    }
}
