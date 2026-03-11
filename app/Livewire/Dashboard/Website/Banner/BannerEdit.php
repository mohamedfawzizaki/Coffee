<?php

namespace App\Livewire\Dashboard\Website\Banner;

use App\Models\Website\Banner\Banner;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
class BannerEdit extends Component
{
    use WithFileUploads;

    public $ar_image;
    public $newArImage;

    public $en_image;
    public $newEnImage;

    public $banner;

    public $link;

    public function mount($id)
    {
        $this->banner = Banner::find($id);

        $this->link = $this->banner->link;
        $this->ar_image = $this->banner->ar_image;
        $this->en_image = $this->banner->en_image;
    }

    #[Title('Edit Banner')]
    public function render()
    {
        return view('livewire.dashboard.website.banner.banner-edit');
    }

    public function updateBanner()
    {
        $this->validate([
            'newArImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'newEnImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url',
        ]);

        $data = [
            'link' => $this->link,
        ];

        // Update Arabic image if new one is uploaded
        if ($this->newArImage) {
            $ar_image_path = $this->newArImage->store('banners', 'public');
            $data['ar_image'] = asset('storage/' . $ar_image_path);
        }

        // Update English image if new one is uploaded
        if ($this->newEnImage) {
            $en_image_path = $this->newEnImage->store('banners', 'public');
            $data['en_image'] = asset('storage/' . $en_image_path);
        }

        $this->banner->update($data);

        request()->session()->flash('success', __('Banner updated successfully'));

        $this->redirect('/dashboard/banner', navigate: true);
    }
}
