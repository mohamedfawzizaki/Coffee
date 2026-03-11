<?php

namespace App\Models\Finance;

use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'customer_id',
        'amount',
        'status',
        'type',
        'order_id',
        'payment_data',
        'payment_order_id',
        'payment_transaction_id',
        'payment_method',
        'place',
        'note',
        'message',
        'car_details',
        'receiver_id',
        'transaction_id',
        'wallet_order_id',
        'wallet_amount',
        'visa_amount',
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
