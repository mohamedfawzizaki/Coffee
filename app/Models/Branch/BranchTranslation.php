<?php

namespace App\Models\Branch;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    use ForceTimeZone;
    protected $guarded = [];

    public $timestamps = false;
}
