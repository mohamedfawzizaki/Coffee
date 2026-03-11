<?php

namespace App\Livewire\Dashboard\Admin\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

class AdminActivity extends Component
{
    #[Title('Admin Activity Log')]
    public function render()
    {
        return view('livewire.dashboard.admin.admin.admin-activity');
    }
}
