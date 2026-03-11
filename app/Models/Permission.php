<?php

namespace App\Models;

use App\Traits\ForceTimeZone;
use Laratrust\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use ForceTimeZone;
    public $guarded = [];
}
