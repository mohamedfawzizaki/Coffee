<?php

namespace App\Http\Resources\Mobile\Cart;

use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            'branch' => new BranchResource($this->branch),
            'total' => $this->total,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'grand_total' => $this->grand_total,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'payment_id' => $this->payment_id,
            'created_at' => $this->created_at,
            'items' => CartItemResource::collection($this->items),
        ];
    }
}
