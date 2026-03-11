<?php

namespace App\Livewire\Dashboard\Review;

use App\Models\Support\Review\Review;
use Livewire\Attributes\Title;
use Livewire\Component;

class ReviewEdit extends Component
{

    public $review;

    public $rating;

    public $comment;

    public function mount($id)
    {
        $this->review = Review::find($id);

        $this->rating = $this->review->rating;

        $this->comment = $this->review->comment;
    }

    #[Title('Edit Review')]
    public function render()
    {
        return view('livewire.dashboard.review.review-edit');
    }


    public function updateReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        $this->review->update([
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->dispatch('refreshReviews');

        request()->session()->flash('success', __('Review updated successfully'));

        $this->redirect(route('dashboard.store.show', $this->review->store_id), navigate: true);
    }
}
