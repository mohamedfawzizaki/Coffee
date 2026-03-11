<?php

namespace App\Http\Resources\Tablet\Profile;

use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TabletProfileResource extends JsonResource
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
            "branch"     => new BranchResource($this->branch),
            "name"       => $this->name,
            "email"      => $this->email,
            "phone"      => $this->phone,
            "image"      => $this->image,
            "status"     => $this->status,
            "created_at" => $this->created_at,
        ];
    }
}
