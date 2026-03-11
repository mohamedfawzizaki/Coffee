<?php

namespace App\Livewire\Dashboard\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileIndex extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3|max:255')]
    public $name;

    #[Rule('nullable|image|mimes:jpeg,png,jpg|max:2048')]
    public $image = null;

    #[Validate('required|email')]
    public $email;

    public $user;

    #[Rule('required|min:8')]
    public $password;

    #[Rule('required|min:8')]
    public $password_confirmation;


    public function mount(){
        $this->user = Auth::guard('admin')->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->image = $this->user->image;
    }

    #[Title('Profile')]
    public function render()
    {
        return view('livewire.dashboard.profile.profile-index',['user' => $this->user]);
    }

    public function updateProfile()
    {
        $validated = $this->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:admins,email,' . $this->user->id,
            'image' => 'nullable|sometimes'
        ]);

        try {

            $user = Auth::guard('admin')->user();

            if ($this->image && !is_string($this->image)) {

                $imagePath = $this->image->store('images', 'public');

                $validated['image'] = asset('storage/' . $imagePath);

            } else {

                $validated['image'] = $this->user->image;
            }

            $user->update($validated);

            request()->session()->flash('success', __('Profile updated successfully'));

            $this->redirect('/dashboard/profile', navigate: true);

        } catch (\Exception $e) {

            request()->session()->flash('error', __('Error updating profile'));
        }
    }

    public function updatePassword()
    {
        $validated = $this->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        try {

            $user = Auth::guard('admin')->user();

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            $this->reset(['password', 'password_confirmation']);

            request()->session()->flash('success', __('Password updated successfully'));

        } catch (\Exception $e) {
            request()->session()->flash('error', __('Error updating password'));
        }
    }
}
