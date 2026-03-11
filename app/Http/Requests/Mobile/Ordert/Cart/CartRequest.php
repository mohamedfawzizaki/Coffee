<?php

namespace App\Http\Requests\Mobile\Ordert\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'size_id'    => 'nullable|exists:productsizes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('Product ID is required'),
            'product_id.exists' => __('Product not found'),
            'quantity.required' => __('Quantity is required'),
            'quantity.integer' => __('Quantity must be a number'),
            'quantity.min' => __('Quantity must be at least 1'),
            'size_id.exists' => __('Product size not found'),
        ];
    }
}
