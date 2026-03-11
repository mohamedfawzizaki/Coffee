<?php

namespace App\Models\Foodics;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class BannedNumber extends Model
{
    use ForceTimeZone;
    protected $fillable = [
        'number'
    ];
}
