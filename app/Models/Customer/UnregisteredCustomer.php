<?php

namespace App\Models\Customer;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class UnregisteredCustomer extends Model
{
    use ForceTimeZone;
   protected $guarded = [];
}
