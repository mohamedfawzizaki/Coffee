<?php

namespace App\Http\Resources\Mobile\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"         => $this->id,
            "name"       => $this->name,
            "phone"      => $this->phone,
            "email"      => $this->email,
            "image"      => $this->image,
            "status"     => $this->status,
            "online"     => $this->online,
            "lat"        => $this->lat,
            "lng"        => $this->lng,
            "address"    => $this->address,
            "wallet"     => $this->wallet,
            "points"     => $this->points,
            "birthday"   => $this->birthday,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "card"       => ($this->card) ? new CardResource($this->card) : null,
        ];
    }
}
