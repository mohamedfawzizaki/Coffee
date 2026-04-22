<?php

namespace App\Livewire\Dashboard\General;

use App\Models\General\Setting;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SettingIndex extends Component
{
    use WithFileUploads;

    public $title, $phone, $email, $address, $logo = null, $favicon = null, $facebook, $twitter, $instagram, $linkedin, $tiktok, $youtube, $android, $ios, $approve;

    public $mail_driver, $mail_host, $mail_port, $mail_username, $mail_password;

    public $api_key, $template_id, $auth_key;

    public $apple_client_id, $apple_team_id, $apple_key_id, $apple_key_file;

    public $google_client_id, $google_client_secret, $google_redirect;

    public $facebook_client_id, $facebook_client_secret, $facebook_redirect;

    public $distance, $money_to_point;

    public $daily_login_points;

    public $friend_invitation_points;

    public $first_register_point;

    public $maintenance;

    public $whatsapp;

    protected $casts = [
        'maintenance' => 'integer',
    ];

    #[Title('Setting')]
    public function render()
    {
        return view('livewire.dashboard.general.setting-index');
    }

    public function updatedMaintenance(): void
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-update'), 403);

        // Ensure we always store 0/1
        $this->maintenance = (int) $this->maintenance;

        $setting = Setting::first();
        if ($setting) {
            $setting->update([
                'maintenance' => $this->maintenance,
            ]);
        }

        // Use the global helper to avoid IDE false-positive on session typing
        \session()->flash('success', __('Setting Updated Successfully'));
    }

    public function mount()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-read'), 403);

        $setting = Setting::first();

        $this->title = $setting->title;
        $this->phone = $setting->phone;
        $this->email = $setting->email;
        $this->address = $setting->address;
        $this->logo = $setting->logo;
        $this->favicon = $setting->favicon;
        $this->facebook = $setting->facebook;
        $this->twitter = $setting->twitter;
        $this->instagram = $setting->instagram;
        $this->linkedin = $setting->linkedin;
        $this->tiktok = $setting->tiktok;
        $this->youtube = $setting->youtube;
        $this->android = $setting->android;
        $this->ios = $setting->ios;
        $this->approve = $setting->approve;
        $this->distance = $setting->distance;
        $this->money_to_point = $setting->money_to_point;
        $this->daily_login_points = $setting->daily_login_points;
        $this->friend_invitation_points = $setting->friend_invitation_points;
        $this->first_register_point = $setting->first_register_point;
        $this->maintenance = $setting->maintenance;
        $this->whatsapp = $setting->whatsapp;
    }

    public function save()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-update'), 403);

        $nullable = 'nullable|sometimes';

         $this->validate([
            'title'      => 'required|string|max:255|min:3',
            'phone'      => 'required|string|max:20|min:10',
            'email'      => 'required|email|max:255|min:3',
            'address'    => 'required|string|max:255|min:3',
            'logo'       => $nullable,
            'favicon'    => $nullable,
            'facebook'   => $nullable,
            'twitter'    => $nullable,
            'instagram'  => $nullable,
            'linkedin'   => $nullable,
            'tiktok'     => $nullable,
            'youtube'    => $nullable,
            'android'    => $nullable,
            'ios'        => $nullable,
            'approve'    => 'required|integer|in:0,1',
            'distance'   => 'required|integer|min:1',
            'money_to_point' => 'required|integer|min:1',
            'daily_login_points' => 'required|integer|min:1',
            'friend_invitation_points' => 'required|integer|min:1',
            'first_register_point' => 'required|numeric|min:0',
            'maintenance' => 'required|boolean',
            'whatsapp' => 'required',
        ]);

        $setting = Setting::first();

        if ($this->logo && !is_string($this->logo)) {

            $imagePath     = $this->logo->store('images/setting', 'public');

            $setting->logo = asset('storage/'.$imagePath);

            $setting->save();
        }

        if ($this->favicon && !is_string($this->favicon)) {

             $imagePath = $this->favicon->store('images/setting', 'public');

             $setting->favicon = asset('storage/'.$imagePath);

            $setting->save();
        }




        $setting->update([
            'title'     => $this->title,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'address'   => $this->address,
            'facebook'  => $this->facebook,
            'twitter'   => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin'  => $this->linkedin,
            'tiktok'    => $this->tiktok,
            'youtube'   => $this->youtube,
            'android'   => $this->android,
            'ios'       => $this->ios,
            'approve'   => $this->approve,
            'distance'  => $this->distance,
            'money_to_point' => $this->money_to_point,
            'daily_login_points' => $this->daily_login_points,
            'friend_invitation_points' => $this->friend_invitation_points,
            'first_register_point' => $this->first_register_point,
            'maintenance' => $this->maintenance,
            'whatsapp' => $this->whatsapp,
            'logo' => $setting->logo,
            'favicon' => $setting->favicon,
        ]);


        \session()->flash('success', __('Setting Updated Successfully'));

        $this->redirect('/dashboard/setting', navigate: true);
    }


}
