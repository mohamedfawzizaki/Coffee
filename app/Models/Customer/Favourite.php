<?php

namespace App\Models\Customer;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use ForceTimeZone;
    protected $fillable = ['customer_id', 'type_id', 'type'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
