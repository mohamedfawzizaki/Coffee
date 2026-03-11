<?php

namespace App\Service\Mobile\Cart;

use App\Http\Resources\Mobile\Cart\GiftCart\GiftCartResource;
use App\Models\Order\Gift\GiftCart;
use App\Models\Order\Gift\GiftCartItem;
use App\Models\Product\Product\Product;
use App\Traits\apiResponse;
use Illuminate\Support\Facades\Auth;
use PDO;

class GiftCartService
{
    use apiResponse;

    public function store($request)
    {
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


        $cart = GiftCart::where('customer_id', Auth::guard('mobile')->user()->id)->where('status', 'pending')->first();

        return  new GiftCartResource($cart);

        return $this->success(__('Product added to cart successfully'));
    }

    private function createCart($request, $price)
    {

        $cart = GiftCart::where('customer_id', Auth::guard('mobile')->user()->id)->where('status', 'pending')->first();

        if (!$cart) {

        $cart = GiftCart::create([
                'customer_id' => Auth::guard('mobile')->user()->id,
                'total'       => $price,
                'grand_total' => $price * $request->quantity,
            ]);
        }

        return $cart;
    }

    private function createCartItem($cart, $request, $price)
    {

        $exists = GiftCartItem::where('gift_cart_id', $cart->id)->where('product_id', $request->product_id)->where('size_id', $request->size_id)->first();

        if ($exists) {
            $qty   = $exists->quantity + $request->quantity;
            $total =  $price * $qty;
            $exists->update([
                'quantity' => $qty,
                'total'    => $total,
            ]);

        } else {

            GiftCartItem::create([
                'gift_cart_id'    => $cart->id,
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
        $item = GiftCartItem::find($id);

        if (!$item) {
            return $this->error(__('Item Not Found'));
        }

        $item->delete();

        $cart = GiftCart::find($item->gift_cart_id);

        if ($cart->items->count() == 0) {
            $cart->delete();
        }else{

            $this->updateCart($cart);
        }

        return $this->success(__('Item Removed From Cart'));
    }

    public function deleteAll()
    {
        $cart = GiftCart::where('customer_id', Auth::guard('mobile')->user()->id)->where('status', 'pending')->first();

        if (!$cart) {
            return $this->error(__('Cart Not Found'));
        }

        $cart->delete();

        return $this->success(__('Cart Cleared'));
    }
}
