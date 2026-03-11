<?php

namespace App\Service\Tablet\Profile;

use App\Http\Resources\Tablet\Profile\TabletProfileResource;
use Illuminate\Support\Facades\Auth;

class TabletProfileService
{

    public function index()
    {
        return new TabletProfileResource(Auth::guard('tablet')->user());
    }

}
