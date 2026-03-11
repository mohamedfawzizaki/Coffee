<?php

namespace App\Models\Product\Category;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class PCategoryTranslation extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public $timestamps = false;
}
