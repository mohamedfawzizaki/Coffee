<?php

namespace App\Livewire\Dashboard\Product\Category;

use App\Models\Product\Category\PCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
class PcategoryEdit extends Component
{
    use WithFileUploads;
    public $category;

    public $categories;
    public $categoryId;
    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $image;
    public $newImage;

    public function mount($id)
    {
        $this->category = PCategory::findOrFail($id);
        $this->categoryId = $this->category->id;
        $this->ar['title'] = $this->category->translate('ar')->title;
        $this->en['title'] = $this->category->translate('en')->title;
        $this->image = $this->category->image;
    }

    public function render()
    {
        return view('livewire.dashboard.product.category.pcategory-edit', [
            'category' => $this->category,
        ]);
    }


    public function updateCategory()
    {
       $this->validate([
            'ar.title'    => 'required|string|max:255',
            'en.title'    => 'required|string|max:255',
            'newImage'    => 'nullable|image|max:1024',
        ]);

        $input = $this->except(['image', 'newImage']);

        $category = PCategory::findOrFail($this->categoryId);

        if ($this->newImage) {

            $imagePath = $this->newImage->store('images/categories', 'public');

            $input['image'] = asset('public/storage/'.$imagePath);

        }else{

            $input['image'] = $this->image;
        }

        $category->update($input);

        session()->flash('success', __('Category updated successfully.'));

       $this->reset(['ar', 'en', 'image', 'newImage']);

       $this->redirect('/dashboard/category', true);
    }

}

