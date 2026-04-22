<?php

namespace App\Livewire\Dashboard\Website\Banner;

use Livewire\Attributes\Title;
use Livewire\Component;

class BannerIndex extends Component
{
    #[Title('Banners')]
    public function mount()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-read'), 403);
    }

    public function render()
    {
        return view('livewire.dashboard.website.banner.banner-index');
    }
}
