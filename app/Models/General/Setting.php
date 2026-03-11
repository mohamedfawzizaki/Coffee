<?php

namespace App\Models\General;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use ForceTimeZone;
   protected $guarded = [];
}
