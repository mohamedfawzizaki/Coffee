<?php

namespace App\Http\Resources\Mobile\Core\Card;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CustomerCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $orders_count = Auth::guard('mobile')->user()->orders()->count();

        $to_have = $this->orders_count - $orders_count;

        $to_have = ($to_have > 0) ? $to_have : 0;

        $is_current = (Auth::guard('mobile')->user()->card_id == $this->id) ? true : false;

        return [
            "id"             => $this->id,
            "title"          => $this->title,
            "image"          => $this->image,
            "money_to_point" => $this->money_to_point,
            "point_to_money" => $this->point_to_money,
            "content"        => $this->content,
            'is_current'     =>  (Auth::guard('mobile')->user()->card_id == $this->id) ? true : false,
            "orders_count"   => $this->orders_count,
            "to_have"        => $to_have,
            "is_current"     => $is_current,
            "created_at"     => $this->created_at,
        ];
    }
}
