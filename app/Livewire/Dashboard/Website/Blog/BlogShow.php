<?php

namespace App\Livewire\Dashboard\Website\Blog;

use App\Models\Website\Blog\Blog;
use Livewire\Attributes\Title;
use Livewire\Component;

class BlogShow extends Component
{
    public $blog;


    public function mount($id)
    {
        $this->blog = Blog::find($id);
    }

    #[Title('Blog Details')]
    public function render()
    {
        return view('livewire.dashboard.website.blog.blog-show');
    }
}
