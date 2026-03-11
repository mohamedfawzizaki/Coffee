<?php

namespace App\Models\Foodics;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Foodics extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
