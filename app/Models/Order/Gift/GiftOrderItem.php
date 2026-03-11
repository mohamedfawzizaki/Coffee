<?php

namespace App\Models\Order\Gift;

use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productsize;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class GiftOrderItem extends Model
{
    use ForceTimeZone;
    protected $fillable = ['gift_order_id', 'product_id', 'size_id', 'price', 'cost_price', 'quantity', 'total', 'note'];

    public function order(){
        return $this->belongsTo(GiftOrder::class, 'gift_order_id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Productsize::class);
    }
}
