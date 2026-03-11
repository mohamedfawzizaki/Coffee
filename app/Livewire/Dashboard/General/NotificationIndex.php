<?php

namespace App\Livewire\Dashboard\General;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class NotificationIndex extends Component
{
    public $notifications;

    public function mount()
    {
        $this->notifications = Auth::guard('admin')->user()->notifications;
    }

    #[Title('الإشعارات')]
    public function render()
    {
        return view('livewire.dashboard.general.notification-index', [
            'notifications' => $this->notifications
        ]);
    }
}
