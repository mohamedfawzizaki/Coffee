<?php

namespace App\Http\Resources\Cashier\Order;

use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use App\Http\Resources\Mobile\Customer\CustomerResource;
use App\Models\Order\Gift\GiftOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleOrderResource extends JsonResource
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
            "branch"        => new BranchResource($this->branch),
            "coupon"        => $this->coupon,
            "manager"       => $this->manager,
            "product"       => $this->product,
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
            "lat"           => $this->lat,
            "lng"           => $this->lng,
            "place"         => $this->place,
            "created_by"    => $this->created_by,
            "title"         => $this->title,
            "message"       => $this->message,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at,
            "items"         => OrderItemResource::collection($this->items),
            "qr"            => $this->qr,
            'car_details'   => $this->car_details,
            'order_type' => $this->order_type ?? ($this->resource instanceof GiftOrder ? 'gift' : 'order'),
       ];
    }
}
