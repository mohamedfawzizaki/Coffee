<?php

namespace App\Models\Customer;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'customer_id',
        'point',
        'qr_code',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
