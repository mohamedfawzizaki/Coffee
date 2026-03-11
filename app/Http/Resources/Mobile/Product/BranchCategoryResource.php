<?php

namespace App\Http\Resources\Mobile\Product;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchProduct;
use App\Models\Product\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $branch_id = (request('branch_id')) ? request('branch_id') : Branch::first()?->id;

        // $products = Product::whereNotIn('id', BranchProduct::where('branch_id', $branch_id)->pluck('product_id'))
        //                     ->active()->where('category_id', $this->id)->orderBy('sort', 'asc')->get();

                              // BranchProduct هنا بيمثل المنتجات "المتاحة" في الفرع
        $products = Product::query()
        ->whereIn('id', BranchProduct::where('branch_id', $branch_id)->where('status', true)->pluck('product_id'))
        ->where('category_id', $this->id)
        ->orderBy('sort', 'asc')
        ->get();

        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'image'    => $this->image,
            'products' => SingleProductResource::collection($products),
        ];
    }
}
