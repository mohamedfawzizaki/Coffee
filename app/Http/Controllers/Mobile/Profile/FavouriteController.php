<?php

namespace App\Http\Controllers\Mobile\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cashier\Menu\ProductResource;
use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use App\Models\Branch\Branch;
use App\Models\Customer\Favourite;
use App\Models\Product\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Auth::guard('mobile')->user();

        $branches = Favourite::where('customer_id', $customer->id)->where('type', 'branch')->pluck('type_id');

        $products = Favourite::where('customer_id', $customer->id)->where('type', 'product')->pluck('type_id');

        $branches = Branch::whereIn('id', $branches)->get();

        $products = Product::whereIn('id', $products)->get();

        return response()->json([
            'branches' => BranchResource::collection($branches),
            'products' => ProductResource::collection($products)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'type'    => 'required|in:branch,product',
            'type_id' => 'required|exists:branches,id|exists:products,id',
        ]);

        $customer = Auth::guard('mobile')->user();

        $favourite = Favourite::where('customer_id', $customer->id)->where('type_id', $request->type_id)->where('type', $request->type)->first();

        if ($favourite) {

            $favourite->delete();

        } else {
            Favourite::create(['customer_id' => $customer->id, 'type_id' => $request->type_id, 'type' => $request->type]);
        }

        return $this->success(__('Favourite Updated successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
