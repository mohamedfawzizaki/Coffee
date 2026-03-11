<?php

namespace App\Http\Resources\Mobile\Product;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchProduct;
use App\Models\Product\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplaceMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'image'    => $this->image,
            'products' => SingleProductResource::collection(Product::active()->where('can_replace', 1)->where('category_id', $this->id)->get()),
        ];
    }
}
