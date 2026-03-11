<?php

namespace App\Http\Controllers\Mobile\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\General\Data\TermsResource;
use App\Http\Resources\Mobile\General\NotificationResource;
use App\Models\General\Faq;
use App\Models\General\Setting;
use App\Models\General\Term;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Mobile\Product\GeneralMenuResource;
use App\Models\Product\Category\PCategory;


class GeneralController extends Controller
{

    public function terms()
    {
       return new TermsResource(Term::first());
    }

    public function setting()
    {
       $setting = Setting::first();

        return response()->json([
            'data' => $setting
        ]);
    }


    public function notifications()
    {
        return response()->json([
            'data' => NotificationResource::collection(Auth::guard('mobile')->user()->notifications)
        ]);
    }


    public function faq()
    {
        return response()->json([
            'faq' => Faq::active()->get()
        ]);
    }

    public function menu()
    {
        $categories = PCategory::active()->orderBy('sort', 'asc')->get();

        return GeneralMenuResource::collection($categories);
    }


}
