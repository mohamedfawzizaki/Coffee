<?php

namespace App\Models\Product\Product;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public $timestamps = false;
}
