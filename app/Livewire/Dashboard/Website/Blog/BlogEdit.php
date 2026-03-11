<?php

namespace App\Livewire\Dashboard\Website\Blog;

use App\Models\Website\Blog\Blog;
use App\Models\Website\Blog\Blogcategory;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class BlogEdit extends Component
{
    use WithFileUploads;
    public $blog;

    public $ar = ['title' => '', 'content' => ''];
    public $en = ['title' => '', 'content' => ''];
    public $image;
    public $newImage;


    public function mount($id)
    {
        $this->blog = Blog::find($id);
        $this->ar['title']   = $this->blog->translate('ar')->title;
        $this->en['title']   = $this->blog->translate('en')->title;
        $this->ar['content'] = $this->blog->translate('ar')->content;
        $this->en['content'] = $this->blog->translate('en')->content;
        $this->image         = $this->blog->image;
    }

    public function render()
    {
        $locales = ['ar', 'en'];
        return view('livewire.dashboard.website.blog.blog-edit', compact('locales'));
    }

    public function saveContentAndUpdate($arContent = null, $enContent = null)
    {
        // Update content from JavaScript if provided
        if ($arContent !== null) {
            $this->ar['content'] = $arContent;
        }
        if ($enContent !== null) {
            $this->en['content'] = $enContent;
        }

        $this->update();
    }

    public function update()
    {
        $this->validate([
            'ar.title'    => 'required|string|max:255',
            'en.title'    => 'required|string|max:255',
            'ar.content'    => 'required|string',
            'en.content'    => 'required|string',
            'newImage'    => 'nullable|image|max:1024',
        ]);

        $blog = Blog::findOrFail($this->blog->id);

        $data = [
            'ar' => [
                'title' => $this->ar['title'],
                'content' => $this->ar['content'],
            ],
            'en' => [
                'title' => $this->en['title'],
                'content' => $this->en['content'],
            ],
        ];

        if ($this->newImage) {
            $imagePath = $this->newImage->store('images/blogs', 'public');
            $data['image'] = asset('storage/'.$imagePath);
        } else {
            $data['image'] = $this->image;
        }

        $blog->update($data);

        request()->session()->flash('success', __('Blog updated successfully.'));

       $this->redirect('/dashboard/blog', true);

    }
}
