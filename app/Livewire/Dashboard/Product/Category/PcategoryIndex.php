<?php

namespace App\Livewire\Dashboard\Product\Category;

use App\Models\Product\Category\PCategory;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class PcategoryIndex extends Component
{

    use WithFileUploads;

    public $categories;
    public $categoryId;
    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $image;

    #[Title("categories")]
    public function render()
    {
        return view('livewire.dashboard.product.category.pcategory-index');
    }

    public function createCategory()
    {
        $input = $this->validate([
            'ar.title' => 'required|string|max:255',
            'en.title' => 'required|string|max:255',
            'image'    => 'nullable|image|max:1024',
        ]);

        if($this->image){
            $imagePath = $this->image->store('images/categories', 'public');

            $input['image'] = asset('public/storage/'.$imagePath);
        }

        PCategory::create($input);

        session()->flash('message', __('Category created successfully.'));

        $this->dispatch('closeModal');

        $this->reset(['ar', 'en', 'image']);
    }

    public function resetForm()
    {
        $this->reset();
    }
}
