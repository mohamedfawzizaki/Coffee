<?php

namespace App\Livewire\Dashboard\General;

use App\Models\General\Contact;
use App\Models\General\ContactMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class ContactShow extends Component
{
    public $contact;

    public $status;

    public $newMessage;

    public function mount($id)
    {
        $this->contact = Contact::find($id);
        $this->status = $this->contact->status;
    }

    #[Title('تواصل معنا')]
    #[On('refresh')]
    public function render()
    {
        return view('livewire.dashboard.general.contact-show');
    }


    public function updateStatus()
    {
        $this->contact->update(['status' => $this->status]);

        $this->dispatch('refresh');

        request()->session()->flash('success', __('Ticket status updated successfully'));
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:255',
         ]);

         $this->reset('newMessage');

         $this->dispatch('messageSent');

         $this->dispatch('refresh');

         request()->session()->flash('success', __('Reply sent successfully'));
    }
}
