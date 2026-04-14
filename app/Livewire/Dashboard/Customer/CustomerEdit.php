<?php

namespace App\Livewire\Dashboard\Customer;

use App\Models\Customer\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
class CustomerEdit extends Component
{
    use WithFileUploads;
    public $customer;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $image;
    public $birthday;

    public function mount($id)
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('customer-update'), 403);

        $this->customer = Customer::find($id);

        $this->name = $this->customer->name;
        $this->email = $this->customer->email;
        $this->phone = $this->customer->phone;
        $this->address = $this->customer->address;
        $this->image = $this->customer->image;
        $this->birthday = $this->customer->birthday;
    }

    #[Title('Edit Customer')]
    public function render()
    {
        return view('livewire.dashboard.customer.customer-edit');
    }

    public function updateCustomer(){

        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('customer-update'), 403);

        $this->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $this->customer->id,
            'phone'   => 'required|string|max:255',
            'birthday' => 'nullable|date_format:Y-m-d|before:' . now()->subYears(7)->toDateString(),
            'image'   => 'nullable|image|max:1024',
        ], [
            'birthday.before' => __('Birthday should be at least 7 years ago'),
            'birthday.date_format' => __('Invalid birthday format. Please use YYYY-MM-DD format'),
        ]);

        $image = $this->image;
        if ($this->image) {
            $image = $this->image->store('images/customer', 'public');
            $image = asset('storage/'.$image);
        }

        $this->customer->update([
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'image'   => $image,
        ]);

        request()->session()->flash('success', __('Customer updated successfully'));

        $this->redirect(route('dashboard.customer.show', $this->customer->id), true);
    }
}
