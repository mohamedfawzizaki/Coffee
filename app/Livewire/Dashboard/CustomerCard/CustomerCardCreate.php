<?php

namespace App\Livewire\Dashboard\CustomerCard;

use App\Models\CustomerCard\CustomerCard;
use App\Traits\ImageUpload;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomerCardCreate extends Component
{
    use WithFileUploads, ImageUpload;

    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $orders_count;
    public $money_to_point;
    public $image;
    public $point_to_money;
    public $content;

    public function mount()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-read'), 403);
    }

    #[Title('Create Customer Card')]
    public function render()
    {
        return view('livewire.dashboard.customer-card.customer-card-create');
    }

    public function createCustomerCard()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-update'), 403);

        $this->validate([
            'ar.title'       => 'required|string|max:255',
            'en.title'       => 'required|string|max:255',
            'orders_count'   => 'required|numeric|min:0',
            'money_to_point' => 'required|numeric|min:0',
            'point_to_money' => 'required|numeric|min:0',
            'image'          => 'nullable|image|max:1024',
            'content'        => 'required|string',
        ]);

        $input = $this->all();

        if($this->image){
            $input['image'] = $this->LivewireImageUpload($this->image, 'images');
        }

        CustomerCard::create($input);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => __('Customer Card Created Successfully')
        ]);

        $this->redirect('/dashboard/customercard', navigate: true);
    }
}
