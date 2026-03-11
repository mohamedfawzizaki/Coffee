<?php

namespace App\Http\Resources\Mobile\Finance;

use App\Http\Resources\Mobile\Order\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PointResource extends JsonResource
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
            "customer_id" => $this->customer_id,
            "order"       => ($this->order) ? new OrderResource($this->order) : null,
            "amount"      => $this->amount,
            "type"        => $this->type,
            "content"     => $this->content,
            "created_at"  => $this->created_at,
        ];
    }
}
