<?php

namespace App\Livewire\Dashboard\General;

use App\Models\Support\Chat\Chat;
use App\Models\Customer\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;

class ChatIndex extends Component
{
    public $selectedChat;

    public $search;

    #[Title('Chats')]
    public function render()
    {
        $chats = Chat::when($this->search, function ($query) {
            $query->whereHas('store', function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            });
        })->latest()->get();



        return view('livewire.dashboard.general.chat-index', compact('chats'));
    }

    public function openChat($id)
    {
        if ($this->selectedChat && $this->selectedChat->id == $id) {
            return;
        }

        $this->selectedChat = Chat::find($id);

        $this->dispatch('chatOpened', $this->selectedChat);
    }
}
