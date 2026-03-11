<?php

namespace App\Models;

use App\Traits\ForceTimeZone;
use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    use ForceTimeZone;
    public $guarded = [];
}
