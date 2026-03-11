<?php

namespace App\Livewire\Dashboard\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $pendingProducts;

    public $pendingServices;

    public $user;


    public function render()
    {
        $this->pendingProducts = 10;

        $this->pendingServices = 5;

        $this->user = Auth::guard('admin')->user();

        $currentRoute = request()->route() ? request()->route()->getName() : '';

        return view('livewire.dashboard.component.sidebar', [
            'pendingProducts' => $this->pendingProducts,
            'pendingServices' => $this->pendingServices,
            'user'            => $this->user,
            'currentRoute'    => $currentRoute,
        ]);
    }
}

