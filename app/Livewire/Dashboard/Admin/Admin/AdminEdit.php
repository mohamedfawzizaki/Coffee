<?php

namespace App\Livewire\Dashboard\Admin\Admin;

use App\Models\Admin\Admin;
use App\Models\Role;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class AdminEdit extends Component
{
    public $admin;
    public $name;
    public $email;
    public $role_id;
    public $newImage;
    public $newPassword;
    public $roles;
    public $image;

    use WithFileUploads;
    #[Title('Admins')]
    public function mount($admin)
    {
        $this->admin = Admin::find($admin);

        $this->name = $this->admin->name;

        $this->email = $this->admin->email;

        $this->role_id = $this->admin->roles()->first()->id;

        $this->roles = Role::where('id', '!=', 1)->get();

        $this->image = $this->admin->image;
    }

    #[Title('Edit Admin')]
    public function render()
    {
        return view('livewire.dashboard.admin.admin.admin-edit');
    }

    public function updateAdmin()
    {
        $validated = $this->validate([
            'name'   => 'required|string|max:255',
            'email'   => 'required|email|unique:admins,email,' . $this->admin->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $image = $this->image;

        if ($this->newImage) {
            $imagePath = $this->newImage->store('admins', 'public');
            $image = asset('public/storage/' . $imagePath);
        }
        $this->admin->update([
            'name'     => $this->name,
            'email'    => $this->email,
            'image'    => $image,
            'password' => $this->newPassword ? bcrypt($this->newPassword) : $this->admin->password,
        ]);

        $this->admin->syncRoles([$this->role_id]);

        request()->session()->flash('success', __('Admin updated successfully'));

        $this->redirect('/dashboard/admin/admin', navigate: true);
    }
}
