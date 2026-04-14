<?php

namespace App\Livewire\Dashboard\General;

use App\Models\Customer\Customer;
use App\Notifications\Admin\MarketingNotification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;

class MarketingIndex extends Component
{
    public $customers_ids;
    public $type;
    public $title;
    public $content;
    public $all_customers = false;
    public $providers_ids;
    public $all_providers = false;

    public $selected_type = 'customers';

    public $has_abandoned_carts = false;
    public $customerSearch = '';

    public function mount()
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('marketing-create'), 403);

        $this->customers_ids = [];
        $this->providers_ids = [];
        // Keep UI + logic in sync (the select options are: customers/new_customers/has_abandoned_carts)
        $this->type = 'customers';
        $this->selected_type = 'customers';
    }

    #[Title('Marketing')]
    public function render()
    {
        $selectedCustomers = collect();
        $customerSearchResults = collect();

        if ($this->selected_type === 'customers' && !$this->all_customers) {
            $ids = array_values(array_unique(array_map('intval', $this->customers_ids ?? [])));

            if (!empty($ids)) {
                $selectedCustomers = Customer::query()
                    ->whereIn('id', $ids)
                    ->select(['id', 'name', 'phone', 'email'])
                    ->get();
            }

            $q = trim((string) $this->customerSearch);
            $limit = $q !== '' ? 20 : 10;

            $customerSearchResults = Customer::query()
                ->when($q !== '', function (Builder $query) use ($q) {
                    $query->where(function (Builder $sub) use ($q) {
                        $sub->where('name', 'like', "%{$q}%")
                            ->orWhere('phone', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
                })
                ->when($q === '', fn (Builder $query) => $query->orderByDesc('id'))
                ->select(['id', 'name', 'phone', 'email'])
                ->limit($limit)
                ->get();

            if (!empty($ids)) {
                $customerSearchResults = $customerSearchResults->reject(fn ($c) => in_array((int) $c->id, $ids, true));
            }
        }

        return view('livewire.dashboard.general.marketing-index', compact('selectedCustomers', 'customerSearchResults'));
    }

    public function addCustomer($customerId): void
    {
        $id = (int) $customerId;
        if ($id <= 0) {
            return;
        }

        $ids = array_values(array_unique(array_map('intval', $this->customers_ids ?? [])));
        if (!in_array($id, $ids, true)) {
            $ids[] = $id;
        }
        $this->customers_ids = $ids;
    }

    public function removeCustomer($customerId): void
    {
        $id = (int) $customerId;
        $this->customers_ids = array_values(array_filter(
            array_map('intval', $this->customers_ids ?? []),
            fn (int $x) => $x !== $id
        ));
    }

    public function sendNotification()
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('marketing-create'), 403);

        // Validate the input data
        $rules = [
            'type'    => 'required|in:new_customers,customers,has_abandoned_carts',
            'title'   => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ];

        if ($this->selected_type === 'customers' && !$this->all_customers) {
            $rules['customers_ids'] = 'required|array|min:1';
        } else {
            $rules['customers_ids'] = 'nullable|array';
        }

        $this->validate($rules);

        $this->sendAppNotification();


        // Handle different types of notifications

        // switch ($this->type) {
        //     case 'email':
        //         $this->sendEmail();
        //         break;
        //     case 'notification':
        //         $this->sendAppNotification();
        //         break;
        //     case 'message':
        //         $this->sendSms();
        //         break;
        // }

        session()->flash('success', __('Notification sent successfully'));

        $this->reset();

        $this->redirect('/dashboard/marketing', navigate: true);
    }

    public function changeType($selected)
    {
        $this->type = $selected;
        $this->selected_type = $selected;
        $this->all_customers = false;
        $this->customers_ids = [];
        $this->customerSearch = '';

        $this->dispatch('contentChanged');
    }

    public function updatedAllCustomers($value)
    {
        // When selecting all customers, we don't need (or want) a massive IDs array in the UI.
        // We will build the target query at send-time.
        $this->customers_ids = [];
        $this->customerSearch = '';
    }

    private function sendEmail()
    {
        // Logic to send email
    }

    private function sendAppNotification()
    {
        $query = $this->targetCustomersQuery();

        $query->select(['id', 'device_token'])->chunkById(500, function ($customers) {
            foreach ($customers as $customer) {
                $customer->notify(new MarketingNotification($this->title, $this->content));
            }
        });
    }

    private function targetCustomersQuery(): Builder
    {
        $query = Customer::query();

        if ($this->selected_type === 'new_customers') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        if ($this->selected_type === 'has_abandoned_carts') {
            $query->whereHas('carts');
        }

        if ($this->selected_type === 'customers' && !$this->all_customers) {
            $ids = array_values(array_unique(array_map('intval', $this->customers_ids ?? [])));
            $query->whereIn('id', $ids);
        }

        return $query;
    }

    private function sendSms()
    {
        // Logic to send SMS
    }
}
