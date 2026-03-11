<?php

namespace App\Models\Product\Product;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Productsize extends Model
{
    use ForceTimeZone;
    protected $fillable = ['product_id', 'ar_title', 'en_title', 'price', 'cost_price', 'image'];

    public function getTitleAttribute()
    {
        return  (app()->getLocale() == 'ar') ?  $this->ar_title : $this->en_title;
    }

}
