<?php

namespace App\Http\Resources\Mobile\Order;

use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use App\Http\Resources\Mobile\Customer\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MiniOrderResource extends JsonResource
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

            "points"        => $this->points,
            "total"         => $this->total,
            "discount"      => $this->discount,
            "tax"           => $this->tax,
            "grand_total"   => $this->grand_total,
            "visa"          => $this->visa,
            "wallet"        => $this->wallet,
            "status"        => $this->status,
            "created_at"    => $this->created_at,

       ];
    }
}
