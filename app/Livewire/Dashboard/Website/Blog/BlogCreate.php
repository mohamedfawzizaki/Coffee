<?php

namespace App\Livewire\Dashboard\Website\Blog;

use App\Models\Website\Blog\Blog;
use App\Models\Website\Blog\Blogcategory;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class BlogCreate extends Component
{
    use WithFileUploads;

    public $categories;

    public $ar = ['title' => '', 'content' => ''];

    public $en = ['title' => '', 'content' => ''];

    public $image;

    #[Title("Create Blog")]
    public function render()
    {
        return view('livewire.dashboard.website.blog.blog-create');
    }

    public function save(){

        $input = $this->validate([
            'ar.title'   => 'required|string|max:255',
            'en.title'   => 'required|string|max:255',
            'ar.content' => 'required|string',
            'en.content' => 'required|string',
            'image'      => 'nullable|image|max:1024',
        ]);

        if($this->image){
            $imagePath = $this->image->store('images/blogs', 'public');
            $input['image'] = asset('storage/'.$imagePath);
        }

       Blog::create($input);

        request()->session()->flash('message', __('Blog created successfully.'));

        $this->redirect('/dashboard/blog', true);
    }

}
