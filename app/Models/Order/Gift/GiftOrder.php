<?php

namespace App\Models\Order\Gift;

use App\Models\Admin\Admin;
use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class GiftOrder extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(GiftOrderItem::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function sendTo(){
        return $this->belongsTo(Customer::class, 'send_to');
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
