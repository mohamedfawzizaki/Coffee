<?php

namespace App\Livewire\Dashboard\Product\Category;

use App\Models\Form\Form;
use App\Models\Product\Category\PCategory;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
class PcategoryCreate extends Component
{
    use WithFileUploads;
    public $categories;

    public $copyForm = false;

    public $categoryId;

    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $image;


    public function mount()
    {
        $this->categories = PCategory::all();
    }

    #[Title('Create Category')]
    public function render()
    {
        return view('livewire.dashboard.product.category.pcategory-create', [
            'copyForm' => $this->copyForm,
        ]);
    }



    public function createCategory(){

        $this->validate([
            'ar.title' => 'required|string|max:255',
            'en.title' => 'required|string|max:255',
        ]);

        $input = $this->except('image');

        if($this->image){

            $imagePath = $this->image->store('images/categories', 'public');

            $input['image'] = asset('public/storage/'.$imagePath);
        }

       PCategory::create($input);


        request()->session()->flash('message', __('Category created successfully.'));

        $this->redirect('/dashboard/category', true);
    }
}
