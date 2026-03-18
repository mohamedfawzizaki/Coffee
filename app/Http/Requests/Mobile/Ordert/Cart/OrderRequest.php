<?php

namespace App\Http\Requests\Mobile\Ordert\Cart;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'place'          => 'required|in:branch,car',
            'payment_method' => 'required|in:cash,visa,wallet,visa-wallet,points',
            'note'           => 'nullable|string',
            'car_details'    => 'required_if:place,car',
            // 'type'           => 'required|in:order,gift,point',
            // 'phone'          => 'required_if:type,gift,point',
            // 'message'        => 'nullable|string',
            // 'amount'         => 'required_if:type,point',
        ];
    }

    public function messages(): array
    {
        return [
            'place.required' => __('Place is required'),
            'place.in' => __('Place must be either branch or car'),
            'payment_method.required' => __('Payment method is required'),
            'payment_method.in' => __('Payment method must be cash, visa, or wallet'),
            'note.string' => __('Note must be a string'),
            'car_details.required_if' => __('Car details are required when place is car'),
        ];
    }
}
