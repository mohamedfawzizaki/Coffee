<?php

namespace App\Http\Resources\Cashier\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "title"       => $this->title,
            "content"     => $this->content,
            "image"       => $this->image,
            "price"       => $this->price,
            "points"      => $this->points,
            "price_type"  => $this->price_type,
            "can_replace" => $this->can_replace,
            "sort"        => $this->sort,
            "status"      => branchProduct($this->id),
            "created_at"  => $this->created_at,
            "updated_at"  => $this->updated_at,
        ];
    }
}
