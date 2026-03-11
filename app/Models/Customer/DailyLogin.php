<?php

namespace App\Models\Customer;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class DailyLogin extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'customer_id',
        'date',
        'points',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
