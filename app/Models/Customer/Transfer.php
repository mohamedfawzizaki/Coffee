<?php

namespace App\Models\Customer;

use App\Models\Admin\Admin;
use App\Models\Provider\Store;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use ForceTimeZone;
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);

    }
}
