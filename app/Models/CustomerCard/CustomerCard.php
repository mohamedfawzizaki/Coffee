<?php

namespace App\Models\CustomerCard;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class CustomerCard extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, ForceTimeZone;

    public $translatedAttributes = ['title'];

    protected $fillable = ['image', 'orders_count', 'money_to_point', 'point_to_money', 'content'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }


}
