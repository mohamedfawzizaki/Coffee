<?php

namespace App\Models\Gift;

use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
        'message',
        'payment_method',
        'payment_id',
     ];

    public function sender()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }
}
