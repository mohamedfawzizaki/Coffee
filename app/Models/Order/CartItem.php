<?php

namespace App\Models\Order;

use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productsize;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use ForceTimeZone;
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'size_id', 'price', 'total'];

    public $timestamps = false;

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Productsize::class);
    }


}
