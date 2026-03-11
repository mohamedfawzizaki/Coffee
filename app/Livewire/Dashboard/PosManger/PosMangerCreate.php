<?php

namespace App\Livewire\Dashboard\PosManger;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchManager;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
class PosMangerCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $image;
    public $password;
    public $status;
    public $branch_id;
    public $branches;

    public function mount()
    {
        $this->branches = Branch::all();
    }

    #[Title('Create Pos Manager')]
    public function render()
    {
        return view('livewire.dashboard.pos-manger.pos-manger-create');
    }

    public function createPosManager()
    {
        $this->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:branch_managers,email',
            'phone'     => 'required|numeric|unique:branch_managers,phone',
            'password'  => 'required|min:8',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $image = null;

        if ($this->image) {
            $imagePath = $this->image->store('branch_managers', 'public');
            $image = asset('public/storage/'.$imagePath);
        }

        BranchManager::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'password'  => bcrypt($this->password),
            'branch_id' => $this->branch_id,
            'image'     => $image,
        ]);

        request()->session()->flash('success', __('Pos Manager created successfully'));

        $this->redirect('/dashboard/posmanager', navigate: true);
    }
}
