<?php

namespace App\Http\Resources\Mobile\Core\Branch;

use App\Http\Resources\Mobile\General\WorkTime\WorkTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchByLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"      => $this->id,
            "title"   => $this->title,
            "address" => $this->address,
            "lat"     => $this->lat,
            "lng" => $this->lng,
            "phone" => $this->phone,
            "email" => $this->email,
            "image" => $this->image,
            "status" => $this->status,
            'open'           => branchOpen($this->id),
            'today_worktime' => WorkTimeResource::make(branchToday($this->id)),
            'is_faved'       => branchFaved($this->id),
            'can_order'      => canOrder($this->id),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "available" => $this->available,
            "distance" => $this->distance,
        ];

    }
}
