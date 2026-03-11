<?php

namespace App\Http\Resources\Mobile\Order\GiftOrder;

use App\Http\Resources\Mobile\Product\ProductResource;
use App\Http\Resources\Mobile\Product\ProductSizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftOrderItemResource extends JsonResource
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
                "order_id"    => $this->order_id,
                "product"     => new ProductResource($this->product),
                "size"        => ($this->size) ? new ProductSizeResource($this->size) : null,
                "price"       => $this->price,
                "quantity"    => $this->quantity,
                "total"       => $this->total,
                "note"        => $this->note,
                "created_at"  => $this->created_at,
                "updated_at"  => $this->updated_at,
            ];
    }
}
