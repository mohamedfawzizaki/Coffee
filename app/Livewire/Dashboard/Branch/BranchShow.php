<?php

namespace App\Livewire\Dashboard\Branch;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchProduct;
use App\Models\Branch\Worktime;
use App\Models\Branch\TabletManger;
use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

class BranchShow extends Component
{
    protected $listeners = ['refreshTabletManager' => 'refreshTabletManager', 'refreshWorktimes' => '$refresh'];

    public $branch;

    public $products;

    public $categories;

    public $availableProducts;

    public $notAvailableProducts;

    public $customers;

    public $months = [];

    public $ordersChart;

    public $day;

    public $from;

    public $to;

    public $all_day = false;

    // Tablet Manager properties
    public $tablet_name;
    public $tablet_email;
    public $tablet_phone;
    public $tablet_password;
    public $tablet_password_confirmation;

    // Edit mode
    public $edit_mode = false;
    public $edit_tablet_name;
    public $edit_tablet_email;
    public $edit_tablet_phone;

    // Reset password mode
    public $reset_password_mode = false;
    public $new_password;
    public $new_password_confirmation;

    // Active tab
    public $activeTab = 'general';

    // Worktime edit mode
    public $edit_worktime_mode = false;
    public $edit_worktime_id;
    public $edit_worktime_day;
    public $edit_worktime_from;
    public $edit_worktime_to;
    public $edit_worktime_all_day = false;

    public function mount($id)
    {
        $this->branch = Branch::withoutGlobalScope('active')->with(['tabletManager'])->find($id);

        // Load active tab from session
        $this->activeTab = session('branch_active_tab', 'general');

        $this->categories = PCategory::all();

        $this->availableProducts = Product::whereNotIn('id', $this->branch->notAvailableProducts->pluck('product_id'))->get();

        $this->notAvailableProducts = Product::whereIn('id', $this->branch->notAvailableProducts->pluck('product_id'))->get();

        $this->customers = Customer::whereHas('orders', function ($query) {
            $query->where('branch_id', $this->branch->id);
        })->get();


        $this->months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];


          foreach ($this->months as $month) {
            $this->ordersChart[] =   Order::where('branch_id', $this->branch->id)->whereMonth('created_at', date('m', strtotime($month)))->count();
          }
    }

    #[Title('Branch Details')]
    public function render()
    {
        return view('livewire.dashboard.branch.branch-show');
    }


    public function changestatus($id)
    {
        $branchProduct = BranchProduct::where('branch_id', $this->branch->id)->where('product_id', $id)->first();

        if ($branchProduct) {

            $branchProduct->update([
                'status' => !$branchProduct->status,
            ]);

        } else {

            BranchProduct::create([
                'branch_id' => $this->branch->id,
                'product_id' => $id,
            ]);
        }

        session()->flash('success', __('Status updated successfully'));

        $this->dispatch('refreshProducts');
    }

    public function addWorktime()
    {
        /** @var array<string, string> $validationRules */
        $validationRules = [
            'day' => 'required',
            'all_day' => 'boolean',
        ];

        if (!$this->all_day) {
            $validationRules['from'] = 'required';
            $validationRules['to'] = 'required';
        }

        $this->validate($validationRules);

        $exists = Worktime::where('branch_id', $this->branch->id)
            ->where('day', $this->day)
            ->exists();

        if ($exists) {
            $this->setActiveTab('worktimes');
            throw ValidationException::withMessages([
                'day' => __('This day is already added'),
            ]);
        }

        /** @var array<string, mixed> $worktimeData */
        $worktimeData = [
            'branch_id' => $this->branch->id,
            'day' => $this->day,
            'from' => $this->all_day ? null : $this->from,
            'to' => $this->all_day ? null : $this->to,
            'all_day' => $this->all_day,
            'status' => true, // Default to active
        ];

        Worktime::create($worktimeData);

        // Reset form
        $this->reset(['day', 'from', 'to', 'all_day']);

        // Cancel edit mode if active
        if ($this->edit_worktime_mode) {
            $this->cancelEditWorktime();
        }

        session()->flash('success', __('Worktime added successfully'));

        // Keep the worktimes tab active
        $this->setActiveTab('worktimes');

        $this->dispatch('refreshWorktimes');
    }

    public function addTabletManager()
    {
        // Check if branch already has a tablet manager
        if ($this->branch->tabletManager) {
            session()->flash('error', __('Branch already has a tablet manager'));
            return;
        }

        /** @var array<string, string> $tabletValidationRules */
        $tabletValidationRules = [
            'tablet_name' => 'required|string|max:255',
            'tablet_email' => 'required|email|unique:tablet_mangers,email',
            'tablet_phone' => 'required|string|unique:tablet_mangers,phone',
            'tablet_password' => 'required|min:6|confirmed',
        ];

        $this->validate($tabletValidationRules);

        /** @var array<string, mixed> $tabletData */
        $tabletData = [
            'branch_id' => $this->branch->id,
            'name' => $this->tablet_name,
            'email' => $this->tablet_email,
            'phone' => $this->tablet_phone,
            'password' => Hash::make($this->tablet_password),
            'status' => true,
        ];

        TabletManger::create($tabletData);

        // Reset form
        $this->reset(['tablet_name', 'tablet_email', 'tablet_phone', 'tablet_password', 'tablet_password_confirmation']);
        $this->resetValidation();

        session()->flash('success', __('Tablet Manager added successfully'));

        // Keep the tablet-manager tab active
        $this->setActiveTab('tablet-manager');

        $this->refreshTabletManager();
    }

    public function removeTabletManager()
    {
        if ($this->branch->tabletManager) {
            $this->branch->tabletManager->delete();
        session()->flash('success', __('Tablet Manager removed successfully'));

        // Keep the tablet-manager tab active
        $this->setActiveTab('tablet-manager');

        $this->refreshTabletManager();
        }
    }

    public function refreshTabletManager()
    {
        $this->branch->load('tabletManager');
        // Reset all modes when refreshing
        $this->edit_mode = false;
        $this->reset_password_mode = false;
        $this->reset(['edit_tablet_name', 'edit_tablet_email', 'edit_tablet_phone', 'new_password', 'new_password_confirmation']);
    }

    public function editTabletManager()
    {
        if ($this->branch->tabletManager) {
            $this->edit_mode = true;
            $this->edit_tablet_name = $this->branch->tabletManager->name;
            $this->edit_tablet_email = $this->branch->tabletManager->email;
            $this->edit_tablet_phone = $this->branch->tabletManager->phone;
        }
    }

    public function updateTabletManager()
    {
        /** @var array<string, string> $validationRules */
        $validationRules = [
            'edit_tablet_name' => 'required|string|max:255',
            'edit_tablet_email' => 'required|email|unique:tablet_mangers,email,' . $this->branch->tabletManager->id,
            'edit_tablet_phone' => 'required|string|unique:tablet_mangers,phone,' . $this->branch->tabletManager->id,
        ];

        $this->validate($validationRules);

        $this->branch->tabletManager->update([
            'name' => $this->edit_tablet_name,
            'email' => $this->edit_tablet_email,
            'phone' => $this->edit_tablet_phone,
        ]);

        $this->cancelEdit();
        session()->flash('success', __('Tablet Manager updated successfully'));

        // Keep the tablet-manager tab active
        $this->setActiveTab('tablet-manager');

        $this->refreshTabletManager();
    }

    public function cancelEdit()
    {
        $this->edit_mode = false;
        $this->reset(['edit_tablet_name', 'edit_tablet_email', 'edit_tablet_phone']);
        $this->resetValidation();
    }

    public function showResetPassword()
    {
        $this->reset_password_mode = true;
    }

    public function resetTabletPassword()
    {
        /** @var array<string, string> $validationRules */
        $validationRules = [
            'new_password' => 'required|min:6|confirmed',
        ];

        $this->validate($validationRules);

        $this->branch->tabletManager->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->cancelResetPassword();
        session()->flash('success', __('Password reset successfully'));

        // Keep the tablet-manager tab active
        $this->setActiveTab('tablet-manager');

        $this->refreshTabletManager();
    }

    public function cancelResetPassword()
    {
        $this->reset_password_mode = false;
        $this->reset(['new_password', 'new_password_confirmation']);
        $this->resetValidation();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session(['branch_active_tab' => $tab]);
    }

    public function editWorktime($worktimeId)
    {
        $worktime = Worktime::find($worktimeId);
        if ($worktime && $worktime->branch_id == $this->branch->id) {
            $this->edit_worktime_mode = true;
            $this->edit_worktime_id = $worktime->id;
            $this->edit_worktime_day = $worktime->day;
            $this->edit_worktime_from = $worktime->from;
            $this->edit_worktime_to = $worktime->to;
            $this->edit_worktime_all_day = $worktime->all_day;
        }
    }

    public function updateWorktime()
    {
        /** @var array<string, string> $validationRules */
        $validationRules = [
            'edit_worktime_day' => 'required',
            'edit_worktime_all_day' => 'boolean',
        ];

        if (!$this->edit_worktime_all_day) {
            $validationRules['edit_worktime_from'] = 'required';
            $validationRules['edit_worktime_to'] = 'required';
        }

        $this->validate($validationRules);

        $worktime = Worktime::find($this->edit_worktime_id);
        if ($worktime && $worktime->branch_id == $this->branch->id) {
            $exists = Worktime::where('branch_id', $this->branch->id)
                ->where('day', $this->edit_worktime_day)
                ->where('id', '!=', $worktime->id)
                ->exists();

            if ($exists) {
                $this->setActiveTab('worktimes');
                throw ValidationException::withMessages([
                    'edit_worktime_day' => __('This day is already added'),
                ]);
            }

            $worktime->update([
                'day' => $this->edit_worktime_day,
                'from' => $this->edit_worktime_all_day ? null : $this->edit_worktime_from,
                'to' => $this->edit_worktime_all_day ? null : $this->edit_worktime_to,
                'all_day' => $this->edit_worktime_all_day,
            ]);

            $this->cancelEditWorktime();
            session()->flash('success', __('Worktime updated successfully'));
            $this->setActiveTab('worktimes');
        }
    }

    public function cancelEditWorktime()
    {
        $this->edit_worktime_mode = false;
        $this->reset(['edit_worktime_id', 'edit_worktime_day', 'edit_worktime_from', 'edit_worktime_to', 'edit_worktime_all_day']);
        $this->resetValidation();
    }

    public function toggleWorktimeStatus($worktimeId)
    {
        $worktime = Worktime::find($worktimeId);
        if ($worktime && $worktime->branch_id == $this->branch->id) {
            $worktime->update(['status' => !$worktime->status]);

            $statusText = $worktime->status ? __('activated') : __('deactivated');
            session()->flash('success', __('Day has been :status successfully', ['status' => $statusText]));
            $this->setActiveTab('worktimes');
        }
    }

    public function deleteWorktime($worktimeId)
    {
        $worktime = Worktime::find($worktimeId);
        if ($worktime && $worktime->branch_id == $this->branch->id) {
            $worktime->delete();
            session()->flash('success', __('Worktime deleted successfully'));
            $this->setActiveTab('worktimes');
        }
    }
}
