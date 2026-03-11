<?php

namespace App\Http\Controllers\Cashier\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cashier\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return new ProfileResource(Auth::guard('cashier')->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        $input = $request->except(['password', 'image']);

        if ($request->has('image')) {

            $input['image'] = $this->ImageUpload($request->image);
        }

        Auth::guard('cashier')->user()->update($input);

        return $this->success(__('Profile updated successfully'));
    }

    public function updatetoken(Request $request)
    {
        $request->validate([
            'device_token' => 'required',
        ]);

        Auth::guard('cashier')->user()->update([
            'device_token' => $request->device_token
        ]);

        return $this->success(__('Profile updated successfully'));
    }


    public function notifications()
    {

        $notifications = Auth::guard('cashier')->user()->notifications;

        if($notifications->count() > 0) {
            $notifications->markAsRead();
        }

        return Auth::guard('cashier')->user()->notifications;
    }

    public function deleteaccount(Request $request)
    {
        // soft delete

        Auth::guard('cashier')->user()->update([
            'status' => 0
        ]);

        return $this->success(__('Account deleted successfully'));
    }

}