<?php

namespace App\Service\Mobile\Cart;

use App\Http\Resources\Mobile\Cart\CartResource;
use App\Http\Resources\Mobile\Product\SingleProductResource;
use App\Models\Branch\Branch;
use App\Models\General\Setting;
use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Product\Product\Product;
use App\Traits\apiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use PDO;

class CartService
{
    use apiResponse;

    public function getCart()
    {
        $cart = Cart::where('customer_id', Auth::guard('mobile')->user()->id)->where('status', 'pending')->first();

        if (!$cart) {
            return $this->error(__('Cart Is Empty'));
        }

        $currentBalance = Auth::guard('mobile')->user()->wallet;

        return response()->json([
            'cart'                     => new CartResource($cart),
            'current_balance'          => number_format($currentBalance, 2),
            'cart_grand_total'         => number_format($cart->grand_total, 2),
            'can_pay_full_with_wallet' => $currentBalance >= $cart->grand_total,
        ]);
    }

    public function store($request)
    {
        $branch = Branch::find($request->branch_id);

        if(!$branch){
            return $this->error(__('Branch not found'));
        }

        $openStatus = canOrder($branch->id);

        if(!$openStatus){
            return $this->error(__('Branch is closed'));
        }

        // $settingDistance = Setting::first()->distance;

        //  $distance = calculateDistance($branch->lat, $branch->lng, $request->lat, $request->lng);

        // if($distance < $settingDistance){
        //     return $this->error(__('Cant Calculate Distance'));
        // }


        $product = Product::find($request->product_id);

        $price   = $product->price;

        // Backward compatible: treat `size` and `sizes` as size-based pricing
        if (in_array($product->price_type, ['size', 'sizes'], true)) {

            if(!is_null($request->size_id)){
                $size  = $product->sizes->find($request->size_id);
                $price = $size->price;

            }else{

                return $this->error(__('Please select size'));
            }

        }

        $cart = $this->createCart($request, $price);

        $this->createCartItem($cart, $request, $price);


        return $this->getCart();

     }

    private function createCart($request, $price)
    {

        $oldCards = Cart::where('customer_id', Auth::guard('mobile')->user()->id)->where('branch_id', "!=", $request->branch_id)->get();

        foreach ($oldCards as $oldCard) {
            $oldCard->delete();
        }

        $cart = Cart::where('customer_id', Auth::guard('mobile')->user()->id)->where('branch_id', $request->branch_id)->where('status', 'pending')->first();

        if (!$cart) {

        $cart = Cart::create([
                'customer_id' => Auth::guard('mobile')->user()->id,
                'branch_id'   => $request->branch_id,
                'total'       => $price,
                'grand_total' => $price * $request->quantity,
            ]);
        }

        return $cart;
    }

    private function createCartItem($cart, $request, $price)
    {

        $exists = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->where('size_id', $request->size_id)->first();

        if ($exists) {
            $qty   = $exists->quantity + $request->quantity;
            $total =  $price * $qty;
            $exists->update([
                'quantity' => $qty,
                'total'    => $total,
            ]);

        } else {

            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'size_id'    => $request->size_id,
                'price'      => $price,
                'total'      => $price * $request->quantity,
            ]);
        }

        $this->updateCart($cart);
    }

    private function updateCart($cart)
    {
        $total = $cart->items->sum('total');

        $grand_total = $total  - $cart->discount + $cart->tax;

        $cart->update([
            'total'       => $total,
            'grand_total' => $grand_total,
        ]);

    }

    public function deleteItem($id)
    {
        $item = CartItem::find($id);

        if (!$item) {
            return $this->error(__('Item Not Found'));
        }

        $item->delete();

        $cart = Cart::find($item->cart_id);

        if ($cart->items->count() == 0) {
            $cart->delete();
        }else{

            $this->updateCart($cart);
        }

        return $this->getCart();

     }

    public function deleteAll()
    {
        $cart = Cart::where('customer_id', Auth::guard('mobile')->user()->id)->where('status', 'pending')->first();

        if (!$cart) {
            return $this->error(__('Cart Not Found'));
        }

        $cart->delete();

        return $this->success(__('Cart Cleared'));
    }

    public function updateQuantityPlus($request)
    {
        $item = CartItem::find($request->item_id);

        if (!$item) {
            return $this->error(__('Item Not Found in Cart'));
        }

        $newQty = $item->quantity + 1;

        return $this->updateCartItem($item, $newQty);


    }

    public function updateQuantityMinus($request)
    {
        $item = CartItem::find($request->item_id);

        if (!$item) {
            return $this->error(__('Item Not Found in Cart'));
        }

        $newQty = $item->quantity - 1;

        if ($newQty < 1) {
            return $this->error(__('Quantity Cannot Be Less Than 1'));
        }

        return $this->updateCartItem($item, $newQty);

    }

    private function updateCartItem($item, $newQty)
    {
        $price = $item->price;

        $total = $price * $newQty;

        $item->update([
            'quantity' => $newQty,
            'total'    => $total,
        ]);

        $this->updateCart($item->cart);

        return $this->getCart();
    }
}
