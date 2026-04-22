<?php

namespace App\Livewire\Dashboard\CustomerCard;

use App\Models\CustomerCard\CustomerCard;
use App\Traits\ImageUpload;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomerCardEdit extends Component
{
    use WithFileUploads, ImageUpload;

    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $orders_count;
    public $image;
    public $customerCard;
    public $money_to_point;
    public $point_to_money;
    public $content;

    public function mount($id)
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-read'), 403);

        $this->customerCard = CustomerCard::findOrFail($id);

        $this->ar['title'] = $this->customerCard->translate('ar')->title;
        $this->en['title'] = $this->customerCard->translate('en')->title;
        $this->orders_count = $this->customerCard->orders_count;
        $this->money_to_point = $this->customerCard->money_to_point;
        $this->point_to_money = $this->customerCard->point_to_money;
        $this->content = $this->customerCard->content;
    }

    public function render()
    {
        return view('livewire.dashboard.customer-card.customer-card-edit');
    }

    public function updateCustomerCard()
    {
        abort_unless(auth('admin')->user()->isAbleTo('setting-update'), 403);

        $this->validate([
            'ar.title'       => 'required|string|max:255',
            'en.title'       => 'required|string|max:255',
            'orders_count'   => 'required|numeric|min:0',
            'money_to_point' => 'required|numeric|min:0',
            'point_to_money' => 'required|numeric|min:0',
            'content'        => 'required|string',
            'image'          => 'nullable|image|max:1024',
        ]);

        $input = $this->all();

        if($this->image){
            $input['image'] = $this->LivewireImageUpload($this->image, 'images');
        } else {
            // Keep current image if no new image is uploaded
            unset($input['image']);
        }

        $this->customerCard->update($input);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => __('Customer Card Updated Successfully')
        ]);

        $this->redirect('/dashboard/customercard', navigate: true);
    }
}
