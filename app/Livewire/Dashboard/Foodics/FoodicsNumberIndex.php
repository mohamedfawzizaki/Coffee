<?php

namespace App\Livewire\Dashboard\Foodics;

use App\Models\Foodics\BannedNumber;
use Livewire\Component;

class FoodicsNumberIndex extends Component
{
    public $number;
    public $showModal = false;

    protected $rules = [
        'number' => 'required|string|max:255|unique:banned_numbers,number'
    ];

    protected $messages = [
        'number.required' => 'رقم الهاتف مطلوب',
        'number.unique' => 'هذا الرقم موجود بالفعل في قائمة الأرقام المحظورة',
        'number.max' => 'رقم الهاتف يجب أن يكون أقل من 255 حرف'
    ];

    public function openModal()
    {
        $this->showModal = true;
        $this->resetValidation();
        $this->reset('number');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset('number');
    }

    public function addNumber()
    {
        $this->validate();

        BannedNumber::create([
            'number' => $this->number
        ]);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'تم إضافة الرقم بنجاح'
        ]);

        $this->closeModal();

        // Refresh the table component
        $this->dispatch('refreshTable');
    }

    public function render()
    {
        return view('livewire.dashboard.foodics.foodics-number-index');
    }
}
