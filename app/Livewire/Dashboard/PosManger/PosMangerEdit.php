<?php

namespace App\Livewire\Dashboard\PosManger;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchManager;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class PosMangerEdit extends Component
{
    use WithFileUploads;

    public $posManager;

    public $name;
    public $email;
    public $phone;
    public $image;
    public $password;
    public $status;
    public $branch_id;
    public $branches;
    public $newImage;
    public $newPassword;

    public function mount($id)
    {
        $this->posManager = BranchManager::find($id);

        $this->name = $this->posManager->name;
        $this->email = $this->posManager->email;
        $this->phone = $this->posManager->phone;
        $this->image = $this->posManager->image;
        $this->status = $this->posManager->status;
        $this->branch_id = $this->posManager->branch_id;
        $this->branches = Branch::all();
    }

    #[Title('Edit Pos Manager')]
    public function render()
    {
        return view('livewire.dashboard.pos-manger.pos-manger-edit');
    }

    public function updatePosManager()
    {
        $this->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:branch_managers,email,' . $this->posManager->id,
            'phone'       => 'required|unique:branch_managers,phone,' . $this->posManager->id,
            'branch_id'   => 'required|exists:branches,id',
            'newPassword' => 'nullable|min:8',
        ]);

        $newImage = null;

        if ($this->newImage) {
            $newImagePath = $this->newImage->store('branch_managers', 'public');
            $newImage = asset('public/storage/'.$newImagePath);
        }


        $this->posManager->update([
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'image'     => ($newImage) ? $newImage : $this->image,
            'branch_id' => $this->branch_id,
            'password'  => ($this->newPassword) ? bcrypt($this->newPassword) : $this->posManager->password,

        ]);

        request()->session()->flash('success', __('Pos Manager updated successfully'));

        $this->redirect('/dashboard/posmanager', navigate: true);
    }
}
