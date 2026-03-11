<?php

namespace App\Http\Resources\Mobile\Core\Branch;

use App\Http\Resources\Mobile\General\WorkTime\WorkTimeResource;
use App\Http\Resources\Mobile\Product\BranchCategoryResource;
use App\Http\Resources\Mobile\Product\CategoryResource;
use App\Models\Product\Category\PCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class SingleBranchResource extends JsonResource
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
            'worktimes'      => WorkTimeResource::collection($this->worktimes),
            // 'categories'     => BranchCategoryResource::collection(PCategory::active()->orderBy('sort', 'asc')->get()),
            'is_faved'       => branchFaved($this->id),
            "created_at"     => $this->created_at,
        ];
    }
}
