<?php

namespace App\Models\General;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class TermTranslation extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public $timestamps = false;
}
