<?php

namespace App\Models\General;

use App\Enums\ContactStatus;
use App\Models\Admin\Admin;
use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use ForceTimeZone;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
