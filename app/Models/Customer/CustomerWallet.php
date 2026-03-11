<?php

namespace App\Models\Customer;

use App\Models\Order\Order;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'customer_id',
        'amount',
        'ar_content',
        'en_content',
        'type',
        'order_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getContentAttribute()
    {
        return (app()->getLocale() == 'ar') ? $this->ar_content : $this->en_content;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
