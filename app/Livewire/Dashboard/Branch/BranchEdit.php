<?php

namespace App\Livewire\Dashboard\Branch;

use App\Models\Branch\Branch;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;

class BranchEdit extends Component
{
    public $branchId;

    public $ar = ['title' => ''];
    public $en = ['title' => ''];
    public $address;
    public $lat;
    public $lng;
    public $phone;
    public $email;
    public $image;

    #[On('latLngUpdated')]
    public function latLngUpdated($lat, $lng): void
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    #[On('addressUpdated')]
    public function addressUpdated($address): void
    {
        $this->address = $address;
    }


    public function mount($id)
    {
        $branch = Branch::findOrFail($id);

        $this->branchId = $branch->id;
        // Use safe translation reads (avoid empty form when translation row is missing)
        $arTranslation = $branch->translate('ar', false);
        $enTranslation = $branch->translate('en', false);

        $fallbackTitle = (string) ($branch->title ?? '');
        $this->ar['title'] = (string) ($arTranslation?->title ?? $fallbackTitle);
        $this->en['title'] = (string) ($enTranslation?->title ?? $fallbackTitle);
        $this->address = $branch->address;
        $this->lat = $branch->lat;
        $this->lng = $branch->lng;
        $this->phone = $branch->phone;
        $this->email = $branch->email;
        $this->image = $branch->image;
    }


    #[Title('Edit Branch')]
    public function render()
    {
        return view('livewire.dashboard.branch.branch-edit');
    }


    public function updateBranch()
    {
        $this->validate([
            'ar.title' => 'required|string|max:255',
            'en.title' => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'lat'      => 'required|numeric',
            'lng'      => 'required|numeric',
        ]);

        $branch = Branch::findOrFail($this->branchId);

        $branch->translateOrNew('ar')->title = $this->ar['title'];
        $branch->translateOrNew('en')->title = $this->en['title'];
        $branch->address = $this->address;
        $branch->lat = $this->lat;
        $branch->lng = $this->lng;
        $branch->phone = $this->phone;
        $branch->email = $this->email;
        $branch->image = $this->image;
        $branch->save();

        session()->flash('success', __('Branch updated successfully'));

        $this->redirect('/dashboard/branch', navigate: true);
    }
}
