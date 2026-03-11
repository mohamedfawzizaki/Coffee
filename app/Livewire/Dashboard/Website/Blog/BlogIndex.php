<?php

namespace App\Livewire\Dashboard\Website\Blog;

use Livewire\Attributes\Title;
use Livewire\Component;

class BlogIndex extends Component
{


    #[Title("Blog")]
    public function render()
    {
        return view('livewire.dashboard.website.blog.blog-index');
    }
}
