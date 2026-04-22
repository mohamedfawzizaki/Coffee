<?php

namespace App\Livewire\Dashboard\Website\Banner;

use App\Models\Website\Banner\Banner;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
class BannerCreate extends Component
{
    use WithFileUploads;

    public $ar_image;

    public $en_image;

    public $link;

    public function mount()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-read'), 403);
    }

    #[Title('Create Banner')]
    public function render()
    {
        return view('livewire.dashboard.website.banner.banner-create');
    }

    public function createBanner()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-create'), 403);

        $this->validate([
            'ar_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'en_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link'     => 'nullable|url',
        ]);

        $ar_image = $this->ar_image->store('banners', 'public');

        $en_image = $this->en_image->store('banners', 'public');

        $ar_image_link = asset('storage/'.$ar_image);

        $en_image_link = asset('storage/'.$en_image);

        Banner::create([
            'ar_image' => $ar_image_link,
            'en_image' => $en_image_link,
            'link'     => $this->link,
        ]);

        request()->session()->flash('success', __('Banner created successfully'));

        $this->redirect('/dashboard/banner', navigate: true);

    }
}
