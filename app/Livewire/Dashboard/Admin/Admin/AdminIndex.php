<?php

namespace App\Livewire\Dashboard\Admin\Admin;

use App\Models\Admin\Admin;
use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Title;

class AdminIndex extends Component
{
    public $model = Admin::class;

    #[Title('Admins')]
    public function render()
    {
        return view('livewire.dashboard.admin.admin.admin-index');
    }
}
