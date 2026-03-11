<?php

namespace App\Http\Controllers\Cashier\Menu;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cashier\Menu\CategoryResource;
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
       return CategoryResource::collection(PCategory::orderBy('sort', 'asc')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function status(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
         ]);

        $branch_id =  Auth::guard('cashier')->user()->branch_id;

        if(!$branch_id) { return $this->error(__('Branch not found')); }

        $exists = BranchProduct::where('branch_id', $branch_id)->where('product_id', $request->product_id)->first();

        $product = Product::find($request->product_id);
        if($exists) {

            $exists->update([
                'status' => !$exists->status,
            ]);
        }else{
            BranchProduct::create([
                'branch_id' => $branch_id,
                'product_id' => $request->product_id,
                'category_id' => $product->category_id,
                'status' =>     true,

            ]);
        }

        return $this->success(__('Status updated successfully'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
