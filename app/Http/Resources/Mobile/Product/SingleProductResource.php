<?php

namespace App\Http\Resources\Mobile\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Mobile\Product\ProductSizeResource;
class SingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'image' => $this->image,
            'status' => $this->status,
            'price' => $this->price,
            'points' => $this->points,
            'price_type' => $this->price_type,
            'can_replace' => $this->can_replace,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'title' => $this->title,
            'content' => $this->content,
            'sizes' => ProductSizeResource::collection($this->sizes),

        ];
    }
}
