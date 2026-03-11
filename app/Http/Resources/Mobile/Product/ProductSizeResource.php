<?php

namespace App\Http\Resources\Mobile\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => (app()->getLocale() == 'ar') ? $this->ar_title : $this->en_title,
            'price'      => $this->price,
        ];
    }
}
