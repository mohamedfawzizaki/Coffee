<?php

namespace App\Http\Resources\Mobile\Cart\GiftCart;

use App\Http\Resources\Mobile\Product\ProductResource;
use App\Http\Resources\Mobile\Product\ProductSizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftCartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "cart_id"     => $this->cart_id,
            "product"     => new ProductResource($this->product),
            "size"        => ($this->size) ? new ProductSizeResource($this->size) : null,
            "price"       => $this->price,
            "quantity"    => $this->quantity,
            "total"       => $this->total,
        ];
    }
}
