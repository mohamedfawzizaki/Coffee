<?php

namespace App\Http\Resources\Mobile\Gift;

use App\Http\Resources\Mobile\Customer\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"            => $this->id,
            "sender"        => new CustomerResource($this->sender),
            "receiver"      => new CustomerResource($this->receiver),
            "message"       => $this->message,
            "payment_method"=> $this->payment_method,
            "amount"        => $this->amount,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at,
        ];
    }
}
