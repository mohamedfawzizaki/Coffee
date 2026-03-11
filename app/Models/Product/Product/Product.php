<?php

namespace App\Models\Product\Product;

use App\Models\Order\OrderItem;
use App\Models\Product\Category\PCategory;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Product extends Model implements TranslatableContract
{
    use Translatable, ForceTimeZone;

    public $translatedAttributes = ['title', 'content'];

    protected $fillable = ['category_id', 'subcategory_id', 'price', 'cost_price', 'image', 'price_type', 'can_replace', 'points', 'status'];

    protected $hidden = [
        'deleted_at',
    ];

    public function sizes()
    {
        return $this->hasMany(Productsize::class);
    }

    public function customFields()
    {
        return $this->hasMany(Productcustom::class);
    }



    public function category()
    {
        return $this->belongsTo(PCategory::class, 'category_id');
    }


    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('images/default.png');
        }

        // If it's already a full URL, return it as-is
        if (is_string($value) && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
            return $value;
        }

        // If it's a storage-relative path, convert to a public URL
        return asset('storage/' . ltrim($value, '/'));
    }

    public function orders()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }



}
