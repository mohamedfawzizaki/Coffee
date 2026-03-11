<?php

namespace App\Http\Controllers\Mobile\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Product\BranchCategoryResource;
use App\Http\Resources\Mobile\Product\CategoryResource;
use App\Http\Resources\Mobile\Product\GeneralMenuResource;
use App\Http\Resources\Mobile\Product\ReplaceMenuResource;
use App\Http\Resources\Mobile\Product\SingleCategoryResource;
use App\Http\Resources\Mobile\Product\SingleProductResource;
use App\Models\Branch\Branch;
use App\Models\Branch\BranchProduct;
use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PCategory::active()->orderBy('sort', 'asc')->get();

        return BranchCategoryResource::collection($categories);
    }

    public function generalMenu()
    {
        $categories = PCategory::active()->orderBy('sort', 'asc')->get();

        return GeneralMenuResource::collection($categories);
    }

    public function replaceMenu()
    {
        $categories = PCategory::active()
        ->whereHas('products', function ($query) {
            $query->where('can_replace', 1);
        })
        ->orderBy('sort', 'asc')->get();

        return [
            'menu'   =>  ReplaceMenuResource::collection($categories),
            'points' => Auth::guard('mobile')->user()->points,
        ];
    }


    public function categories(Request $request)
    {
        $categories = PCategory::active()->orderBy('sort', 'asc')->get();

        return CategoryResource::collection($categories);
    }


    public function category(string $id)
    {
        $category = PCategory::find($id);

        if (!$category) { return $this->notFound();    }

        return new BranchCategoryResource($category);
    }


    public function product(string $id)
    {
        $product = Product::with('sizes')->find($id);

        if (!$product) { return $this->notFound();    }

        $branch_id = (request('branch_id')) ? request('branch_id') : Branch::first()?->id;

        // BranchProduct بيمثل المنتجات "المتاحة" في الفرع
        $available = BranchProduct::where('branch_id', $branch_id)->where('product_id', $product->id)->exists();

        if (!$available) { return $this->error(__("Product Not Available In This Branch"));    }

        return new SingleProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
