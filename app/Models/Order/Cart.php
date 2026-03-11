<?php

namespace App\Models\Order;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\Finance\Coupon;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Cart extends Model
{
    use LogsActivity, ForceTimeZone;
   protected $guarded = [];


   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()->logAll();
   }

   public function items()
   {
       return $this->hasMany(CartItem::class);
   }

   public function coupon()
   {
       return $this->belongsTo(Coupon::class);
   }

   public function customer()
   {
       return $this->belongsTo(Customer::class);
   }

   public function branch()
   {
       return $this->belongsTo(Branch::class);
   }
}
