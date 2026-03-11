<?php

namespace App\Models\Product\Category;


use App\Models\Product\Product\Product;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class PCategory extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, ForceTimeZone;

    public $translatedAttributes = ['title'];

    protected $fillable = ['status', 'image', 'price_type', 'sort'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getImageAttribute($value)
    {
        return  ($value) ?  $value : asset('images/default.png');
    }
}
