<?php

namespace App\Models\Website\Banner;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public function getImageAttribute()
    {
        return  (app()->getLocale() == 'ar') ?  $this->ar_image: $this->en_image;
    }


}
