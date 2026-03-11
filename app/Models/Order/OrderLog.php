<?php

namespace App\Models\Order;

use App\Models\Branch\BranchManager;
use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getContentAttribute()
    {
        return (app()->getLocale() == 'ar') ? $this->ar_content : $this->en_content;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function manager()
    {
        return $this->belongsTo(BranchManager::class, 'manager_id');
    }

}
