<?php

namespace App\Http\Controllers\Customer\General;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\Adds\AddsResource;
use App\Http\Resources\Customer\Adds\SingleAddsResource;
use App\Http\Resources\Customer\Offer\OfferResource;
use App\Http\Resources\Customer\Profile\FamilyResource;
use App\Http\Resources\Customer\Profile\ProfileResource;
use App\Http\Resources\Customer\Service\ServiceResource;
use App\Models\Adds\Adds;
use App\Models\Chat\Chat;
use App\Models\Chat\Chatmessage;
use App\Models\Customer\Family;
use App\Models\General\Contact;
use App\Models\Offer\Offer;
use App\Models\Order\Order;
use App\Models\Setup\Category;
use App\Models\Userapp\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user        = Auth::guard('customer')->user();

        $categories = Category::active()->get();

        $unread_messages = ($user) ? Chatmessage::where('receiver_id', $user->id)
            ->where('seen', false)
            ->count() : 0;

        $latest_notifications = ($user) ? $user->notifications()
            ->latest()
            ->limit(5)
            ->get() : [];

        $latest_chats = ($user) ? Chat::where('customer_one', $user->id)
            ->orWhere('customer_two', $user->id)
            ->latest()
            ->limit(5)
            ->get() : [];

        $unread_notifications = ($user) ? $user->unreadNotifications()->count() : 0;

        $adds = Adds::whereStatus('pending')->latest()
            ->when(request()->has('category_id'), function ($query) {
                return $query->where('category_id', request()->get('category_id'));
            })
            ->when(request()->has('subcategory_id'), function ($query) {
                return $query->where('subcategory_id', request()->get('subcategory_id'));
            })
            ->when(request()->has('region_id'), function ($query) {
                return $query->where('region_id', request()->get('region_id'));
            })
            ->when(request()->has('city_id'), function ($query) {
                return $query->where('city_id', request()->get('city_id'));
            })

            ->paginate(10);

        return response()->json([
            'user'                => ($user) ? new ProfileResource($user) : null,
            'categories'          => $categories,
            'unread_messages'     => $unread_messages,
            'latest_notifications'=> $latest_notifications,
            'latest_chats'        => $latest_chats,
            'unread_notifications'=> $unread_notifications,
            'adds'                => AddsResource::collection($adds),
        ]);

    }

    public function search()
    {
        $adds = Adds::when(request()->has('title'), function ($query) {
            return $query->where('title', 'like', '%' . request()->get('title') . '%');
        })
        ->when(request()->has('content'), function ($query) {
            return $query->where('content', 'like', '%' . request()->get('content') . '%');
        })
        ->when(request()->has('category_id'), function ($query) {
            return $query->where('category_id', request()->get('category_id'));
        })
        ->when(request()->has('subcategory_id'), function ($query) {
            return $query->where('subcategory_id', request()->get('subcategory_id'));
        })->paginate(10);

        return AddsResource::collection($adds);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function contact(Request $request)
    {
        $request->validate([
            'title'      => 'required|string',
            'message'   => 'required|string',
        ]);

        Contact::create([
            'customer_id'  => auth('customer')->user() ? auth('customer')->id() : null,
            'title'        => $request->title,
            'message'      => $request->message,
         ]);

        return $this->success(__('Message sent successfully'));
    }


}
