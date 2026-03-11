<?php

namespace App\Http\Controllers\Mobile\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Profile\UpdateProfileRequest;
use App\Http\Resources\Mobile\General\NotificationResource;
use App\Http\Resources\Mobile\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProfileResource(Auth::guard('mobile')->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        $input = $request->except(['password', 'image']);

        if ($request->has('image')) {

            $input['image'] = $this->ImageUpload($request->image);
        }

        Auth::user()->update($input);

        return $this->success(__('Profile updated successfully'));
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required',
        ]);

        $customer = Auth::guard('mobile')->user();

        $customer->update(['device_token' => $request->device_token]);

        return $this->success(__('FCM token updated successfully'));
    }

    public function notifications()
    {
        $notifications = Auth::guard('mobile')->user()->notifications;

        if($notifications->count() > 0) {
            $notifications->markAsRead();
        }

        return NotificationResource::collection(Auth::guard('mobile')->user()->notifications);
    }

    public function deleteaccount(Request $request)
    {
        // soft delete

        Auth::user()->update([
            'status' => 0
        ]);

        return $this->success(__('Account deleted successfully'));
    }
}
