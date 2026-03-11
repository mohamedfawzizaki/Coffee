<?php

namespace App\Http\Controllers\Mobile\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Core\Card\CustomerCardResource;
use App\Http\Resources\Mobile\General\Data\BannerResource;
use App\Http\Resources\Mobile\Profile\ProfileResource;
use App\Models\CustomerCard\CustomerCard;
use App\Models\Website\Banner\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $user = Auth::guard('mobile')->user();

      $sliders = Banner::active()->get();

      $unreadNotifications = $user->unreadNotifications()->count();
      return response()->json([
        
        'user'    => new ProfileResource($user),
        'sliders' => BannerResource::collection($sliders),
        'card'    => ($user->card) ? new CustomerCardResource($user->card) : null,
        'unreadNotifications' => $unreadNotifications,
      ]);
    }


    public function customercards()
    {
        $customercards = CustomerCard::latest()->get();

        return  CustomerCardResource::collection($customercards);

    }

}
