<?php

namespace App\Http\Resources\Mobile\Order\GiftOrder;

use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use App\Http\Resources\Mobile\Customer\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftOrderResource extends JsonResource
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
            "customer"      => new CustomerResource($this->customer),
            "send_to"       => ($this->sendTo) ? new CustomerResource($this->sendTo) : null,
            "coupon"        => $this->coupon,
            "manager"       => $this->manager,
            "admin"         => $this->admin,
            "points"        => $this->points,
            "total"         => $this->total,
            "discount"      => $this->discount,
            "tax"           => $this->tax,
            "grand_total"   => $this->grand_total,
            "visa"          => $this->visa,
            "wallet"        => $this->wallet,
            "status"        => $this->status,
            "type"          => $this->type,
            "payment_method"=> $this->payment_method,
            "payment_status"=> $this->payment_status,
            "payment_id"    => $this->payment_id,
            "note"          => $this->note,
            "created_by"    => $this->created_by,
            "title"         => $this->title,
            "message"       => $this->message,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at,
            "qr"            => $this->qr,
            "items"         => GiftOrderItemResource::collection($this->items),

       ];
    }
}
