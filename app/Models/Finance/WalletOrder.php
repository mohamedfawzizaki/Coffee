<?php

namespace App\Models\Finance;

use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class WalletOrder extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'customer_id',
        'order_id',
        'payment_id',
        'wallet_amount',
        'visa_amount',
        'status',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
