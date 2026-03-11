<?php

namespace App\Models\General;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Term extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, ForceTimeZone;

    public $translatedAttributes = ['content'];

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

}
