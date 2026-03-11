<?php

namespace App\Http\Controllers\Tablet\Auth;

use App\Http\Controllers\Controller;
use App\Service\Tablet\Profile\TabletProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private TabletProfileService $tabletProfileService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->tabletProfileService->index();
    }

}
