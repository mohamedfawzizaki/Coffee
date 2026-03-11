<?php

namespace App\Livewire\Dashboard\Website\Search;

use Livewire\Attributes\Title;
use Livewire\Component;

class SearchIndex extends Component
{
    #[Title('Search')]
    public function render()
    {
        return view('livewire.dashboard.website.search.search-index');
    }
}
