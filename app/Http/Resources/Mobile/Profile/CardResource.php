<?php

namespace App\Http\Resources\Mobile\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"             => $this->id,
            "title"          => $this->title,
            "image"          => $this->image,
            "amount"         => $this->amount,
            "money_to_point" => $this->money_to_point,
            "point_to_money" => $this->point_to_money,
            "days"           => $this->days,
            "content"        => $this->content,
            "created_at"     => $this->created_at,
            "updated_at"     => $this->updated_at,
        ];
    }
}
