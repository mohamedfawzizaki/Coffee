<?php

namespace App\Models\CustomerCard;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class CustomerCardTranslation extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public $timestamps = false;

}
