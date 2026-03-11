<?php

namespace App\Models\Order;

use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productsize;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use ForceTimeZone;
    protected $fillable = ['order_id', 'product_id', 'size_id', 'price', 'cost_price', 'quantity', 'total', 'note', 'is_refunded', 'refunded_at'];

    protected $casts = [
        'is_refunded' => 'boolean',
        'refunded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
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
