<?php

namespace App\Livewire\Dashboard\Branch;


use Livewire\Attributes\Title;
use Livewire\Component;

class BranchCreate extends Component
{
    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $address;
    public $lat;
    public $lng;
    public $phone;
    public $email;
    public $image;

    #[Title('Create Branch')]
    public function render()
    {
        return view('livewire.dashboard.branch.branch-create');
    }


    public function createBranch()
    {
        $this->validate([
            'ar.title' => 'required',
            'en.title' => 'required',
            'address'  => 'required',
            'lat'      => 'required',
            'lng'      => 'required',
            'phone'    => 'required',
            'email'    => 'required',
            'image'    => 'required',
        ]);

        Branch::create($this->all());

        request()->session()->flash('success', __('Branch created successfully'));

        return redirect()->route('dashboard.branch.index');
    }
}
