<?php

namespace App\Models\General;

use App\Models\Customer\Customer;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use ForceTimeZone;
    protected $fillable = ['keyword', 'customer_id', 'ip', 'user_agent'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
