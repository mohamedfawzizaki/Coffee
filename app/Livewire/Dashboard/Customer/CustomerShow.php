<?php

namespace App\Livewire\Dashboard\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPoint;
use App\Models\Customer\CustomerWallet;
use App\Models\Support\Review\Review;
use App\Notifications\Admin\MarketingNotification;
use Livewire\Attributes\Title;
use Livewire\Component;

class CustomerShow extends Component
{
    public bool $persist = false;

    public $customer;

    public $ordersChart;

    public $reviews;

    public $five;
    public $four;
    public $three;
    public $two;
    public $one;

    public $amount;
    public $ar_content;
    public $en_content;


    public function mount($id)
    {
        $this->customer = Customer::find($id);

        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

        $this->ordersChart = collect($months)->map(function ($month) {
            return [
                'month' => $month,
                'orders' => $this->customer->orders()->whereMonth('created_at', date('m', strtotime($month)))->count(),
            ];
        });

        // $this->five = $this->customer->reviews()->where('rating', 5)->count();
        // $this->four = $this->customer->reviews()->where('rating', 4)->count();
        // $this->three = $this->customer->reviews()->where('rating', 3)->count();
        // $this->two = $this->customer->reviews()->where('rating', 2)->count();
        // $this->one = $this->customer->reviews()->where('rating', 1)->count();
        // $this->reviews = $this->customer->reviews()->get();

    }

    #[Title('Customer Details')]
    public function render()
    {
        return view('livewire.dashboard.customer.customer-show', ['customer' => $this->customer]);
    }

    public function addTransfer()
    {
        dd($this->customer);
    }


    public function deleteReview($id)
    {
        $review = Review::find($id);

        $review->delete();

        $this->dispatch('refreshReviews');

        request()->session()->flash('success', __('Review deleted successfully'));

        $this->redirect(route('dashboard.customer.show', $this->customer->id), true);
    }

    public function addPoints()
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('customer-update'), 403);

        $this->validateMoney();

      CustomerPoint::create([
        'customer_id' => $this->customer->id,
        'amount'      => $this->amount,
        'ar_content'  => $this->ar_content,
        'en_content'  => $this->en_content,
        'type'        => 'in',
       ]);

       $this->customer->update([
        'points' => $this->customer->points + $this->amount,
       ]);

       $this->reset('amount', 'ar_content', 'en_content');

       $this->customer->notify(new MarketingNotification('Points Added', 'You have received ' . $this->amount . ' points from admin'));

       request()->session()->flash('success', __('Points added successfully'));

       $this->redirect(route('dashboard.customer.show', $this->customer->id), true);
    }

    public function addMoney()
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('customer-update'), 403);

        $this->validateMoney();

           $this->customer->update([
            'wallet' => $this->customer->wallet + $this->amount,
           ]);

           CustomerWallet::create([
            'customer_id' => $this->customer->id,
            'amount'      => $this->amount,
            'ar_content'  => $this->ar_content,
            'en_content'  => $this->en_content,
            'type'        => 'in',
           ]);

           $this->reset('amount', 'ar_content', 'en_content');

           $this->customer->notify(new MarketingNotification('Money Added', 'You have received ' . $this->amount . ' money from admin'));

           request()->session()->flash('success', __('Money added successfully'));

           $this->redirect(route('dashboard.customer.show', $this->customer->id), true);

    }

    public function validateMoney()
    {
        $this->validate([
            'amount'     => 'required|numeric',
            'ar_content' => 'required|string',
            'en_content' => 'required|string',
        ]);
    }

}
