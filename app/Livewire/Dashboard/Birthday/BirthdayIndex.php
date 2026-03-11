<?php

namespace App\Livewire\Dashboard\Birthday;

use App\Models\Product\Product\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Customer\Customer;
use App\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BirthdayIndex extends Component
{
    #[Title('Customers Birthdays')]

    public $datefrom;
    public $dateto;
    public $todayBirthdays = 0;
    public $monthBirthdays = 0;
    public $sentGifts = 0;

    public $products;
    public $product_id;
    public $customer_ids = [];
    public $selectedCustomers = [];
    public $showCanvas = false;

    public $title;
    public $message;

    public function mount()
    {
        $this->products = Product::all();
        $this->loadStats();
    }

    #[On('showCanvas')]
    public function showCanvas()
    {
        $this->showCanvas = true;
        $this->dispatch('canvasStateChanged', true);
    }

    public function hideCanvas()
    {
        $this->showCanvas = false;
        $this->dispatch('canvasStateChanged', false);
    }

    #[On('set-customer-ids')]
    public function setCustomerIds($ids)
    {
        // Log the received IDs for debugging
        Log::info('Received customer IDs: ' . json_encode($ids));

        if (is_array($ids) && count($ids) > 0) {
            $this->customer_ids = $ids;

            // Get customer details for display
            $customers = Customer::whereIn('id', $this->customer_ids)->get();

            if ($customers->isNotEmpty()) {
                $this->selectedCustomers = $customers->map(function($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'image' => $customer->image ? asset($customer->image) : asset('assets/images/users/default.png')
                    ];
                })->toArray();

                Log::info('Selected customers for display: ' . count($this->selectedCustomers));
            } else {
                $this->selectedCustomers = [];
                $this->showCanvas = false;
                Log::warning('No customers found with the provided IDs');
            }
        } else {
            $this->customer_ids = [];
            $this->selectedCustomers = [];
            Log::warning('No valid customer IDs received');
        }
    }

    public function loadStats()
    {

        $today = Carbon::today()->format('m-d');

        $this->todayBirthdays = Customer::whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [$today])->count();

        $currentMonth = Carbon::today()->format('m');

        $this->monthBirthdays = Customer::whereRaw("MONTH(birthday) = ?", [$currentMonth])->count();

        $this->sentGifts = Order::where('type', 'gift')->where('created_by', 'admin')->count();
    }

    public function filter()
    {
        $this->validate([
            'datefrom' => 'required|date',
            'dateto' => 'required|date|after_or_equal:datefrom',
        ]);

        $this->dispatch('dateRangeUpdated', $this->datefrom, $this->dateto);
    }

    public function render()
    {
        return view('livewire.dashboard.birthday.birthday-index');
    }

    public function clearFilter()
    {
        $this->datefrom = null;
        $this->dateto = null;
        $this->dispatch('dateRangeUpdated', null, null);
    }

    public function sendgift()
    {
        // Validate product selection
        $this->validate([
            'product_id'  => 'required|exists:products,id',
            'title'       => 'required|string|max:255',
            'message'     => 'required|string',
            'expire_date' => 'required|date',
        ]);

        if (empty($this->customer_ids)) {
            Session::flash('error', __('No customers selected!'));
            return;
        }

        // Get selected customers from database
        $customers = Customer::whereIn('id', $this->customer_ids)->get();

        if ($customers->isEmpty()) {
            Session::flash('error', __('No valid customers found!'));
            return;
        }

        $product = Product::find($this->product_id);

            foreach ($customers as $customer) {
               $order = Order::create([
                    'send_to'    => $customer->id,
                    'title'      => $this->title,
                    'message'    => $this->message,
                    'created_by' => 'admin',
                    'admin_id'   => Auth::guard('admin')->user()->id,
                    'type'       => 'gift',
                    'total'      => $product->price,
                    'grand_total' => $product->price,
                ]);

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => 1,
                    'price'      => $product->price,
                    'total'      => $product->price,

                ]);
            }

            Session::flash('success', __(':count gifts have been sent successfully!', ['count' => $customers->count()]));

            $this->redirect('/dashboard/birthday', navigate: true);


    }
}
