<?php

namespace App\Models\Order\Gift;

use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productsize;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class GiftCartItem extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'gift_cart_id',
        'product_id',
        'size_id',
        'price',
        'quantity',
        'total',
    ];

    public function giftCart()
    {
        return $this->belongsTo(GiftCart::class, 'gift_cart_id');
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
