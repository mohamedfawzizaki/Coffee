<?php

namespace App\Models\Website\Blog;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public $timestamps = false;
}
