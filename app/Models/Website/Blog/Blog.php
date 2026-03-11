<?php

namespace App\Models\Website\Blog;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Blog extends Model  implements TranslatableContract
{
    use Translatable, LogsActivity, ForceTimeZone;

    public $translatedAttributes = ['title', 'content'];

    protected $fillable = ['status', 'image', 'views'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function getImageAttribute($value)
    {
        return  ($value) ?  $value : asset('images/placeholder.webp');
    }


}
