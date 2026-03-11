<?php

namespace App\Livewire\Dashboard\General;

use Livewire\Attributes\Title;
use Livewire\Component;

class ContactIndex extends Component
{
    #[Title('Contact Us')]
    public function render()
    {
        return view('livewire.dashboard.general.contact-index');
    }
}
