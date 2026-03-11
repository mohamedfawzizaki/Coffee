<?php

namespace App\Http\Resources\Mobile\Finance;

use App\Http\Resources\Mobile\Order\MiniOrderResource;
use App\Http\Resources\Mobile\Order\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"              => $this->id,
            "customer_id"     => $this->customer_id,
            "order"           => ($this->order) ? new MiniOrderResource($this->order) : null,
            "amount"          => $this->amount,
            "type"            => $this->type,
            "content"         => $this->content,
            "payment_method"  => $this->payment_method,
            "payment_status"  => $this->payment_status,
            "payment_details" => $this->payment_details,
            "created_at"      => $this->created_at,
        ];
    }
}
