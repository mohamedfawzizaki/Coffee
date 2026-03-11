<?php

namespace App\Http\Resources\Mobile\Core\Branch;

use App\Http\Resources\Mobile\General\WorkTime\WorkTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            "address"        => $this->address,
            "title"          => $this->title,
            "lat"            => $this->lat,
            "lng"            => $this->lng,
            "phone"          => $this->phone,
            "email"          => $this->email,
            "image"          => $this->image,
            "status"         => $this->status,
            'open'           => branchOpen($this->id),
            'today_worktime' => WorkTimeResource::make(branchToday($this->id)),
            'is_faved'       => branchFaved($this->id),
            'can_order'      => canOrder($this->id),
            "created_at"     => $this->created_at,
        ];
    }
}
