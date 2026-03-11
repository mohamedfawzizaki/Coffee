<?php

namespace App\Models\Order\Gift;

use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class GiftCart extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'customer_id',
        'total',
        'discount',
        'tax',
        'grand_total',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(GiftCartItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
