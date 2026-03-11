<?php

namespace App\Livewire\Dashboard\Admin\Admin;

use App\Models\Admin\Admin;
use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class AdminCreate extends Component
{
    use WithFileUploads;
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email|unique:admins,email')]
    public $email;

    #[Validate('required|string|min:8')]
    public $password;

    #[Validate('required|exists:roles,id')]
    public $role_id;

    public $image;

    #[Title('Admins')]
    public function render()
    {
        $roles = Role::where('id', '!=', 1)->get();

        return view('livewire.dashboard.admin.admin.admin-create', compact('roles'));
    }

    public function createAdmin()
    {
       $this->validate();

       $image = null;

       if ($this->image) {

        $imagePath = $this->image->store('admins', 'public');

        $image = asset('public/storage/'.$imagePath);

       }

      $admin = Admin::create([
        'name'     => $this->name,
        'email'    => $this->email,
        'password' => bcrypt($this->password),
        'role_id'  => $this->role_id,
        'image'    => $image,
       ]);

       $admin->addRole($this->role_id);

       request()->session()->flash('success', __('Admin created successfully'));

       $this->redirect('/dashboard/admin/admin', navigate: true);
    }
}
