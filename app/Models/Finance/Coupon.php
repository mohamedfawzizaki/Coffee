<?php

namespace App\Models\Finance;

use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use ForceTimeZone;
   protected $guarded = [];

   public function customer()
   {
       return $this->belongsTo(Customer::class);
   }
}
