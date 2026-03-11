<?php

namespace App\Http\Requests\Mobile\Ordert\Cart;

use Illuminate\Foundation\Http\FormRequest;

class GiftOrderRequest extends FormRequest
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
            // 'place'          => 'required|in:branch,car',
            'payment_method' => 'required|in:cash,visa,wallet',
            'note'           => 'nullable|string',
            'phone'          => 'required',
            'message'        => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => __('Payment method is required'),
            'payment_method.in' => __('Payment method must be cash, visa, or wallet'),
            'note.string' => __('Note must be a string'),
            'phone.required' => __('Phone is required'),
            'message.string' => __('Message must be a string'),
        ];
    }
}
