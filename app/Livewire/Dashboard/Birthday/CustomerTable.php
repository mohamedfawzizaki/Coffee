<?php

namespace App\Livewire\Dashboard\Birthday;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataTableExport;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CustomerTable extends BaseTable
{
    protected $actionDisplay = ['show', 'delete', 'edit'];

    protected $route         = 'dashboard.customer';

    public $model            = Customer::class;

    public $datefrom;
    public $dateto;
    public $customer_ids;

    #[On('dateRangeUpdated')]
    public function updateDateRange($datefrom, $dateto)
    {
        $this->datefrom = $datefrom;

        $this->dateto = $dateto;

        $this->refreshTable();
    }

    public function refreshTable()
    {
        $this->resetPage();
    }

    public function builder(): Builder
    {
        return $this->model::query()
            ->when($this->getAppliedFilterWithValue('status') !== null, function ($query) {
                $query->where('status', $this->getAppliedFilterWithValue('status'));
            })
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00', Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59']);
            })
            ->when($this->datefrom && $this->dateto, function ($query) {

                $query->whereBetween('birthday', [$this->datefrom, $this->dateto]);
            });
    }

    public function columns(): array
    {
        return [

            Column::make(__('ID'), 'id')->searchable()->sortable(),

            Column::make(__('Name'), 'name')->format(function ($value, $column, $row) {
                return  $this->nameWithImage($column->name, $column->image, $column->id);
            })->html()->searchable()->sortable(),

            Column::make(__('Phone'), 'phone')->searchable()->sortable(),

            Column::make(__('Birthday'), 'birthday')->searchable()->sortable(),

        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTableAttributes([
            'class' => 'table-hover table-rounded table align-middle table-nowrap mb-0',
        ]);

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });

        $this->setTdAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });

        $this->setFooterTdAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });
        $this->setDefaultSort($this->orderBy, $this->orderType);
        $this->setDefaultSortingLabels(__('Ascending'), __('Descending'));
        if ($this->enableBulk) {
            $this->setBulkActions([
                'sendGifts' => __('Send Gifts')
            ]);
        }
        if ($this->dbSelect) {
            $this->setAdditionalSelects('*');
        }
        $this->setPerPageAccepted([10, 25, 50, 100]);
        $this->setPerPage(10);
        $this->setFooterEnabled();

        $this->setSearchLive();

        $this->setSearchIcon('heroicon-m-magnifying-glass');
    }

    public function sendGifts()
    {
        $ids = $this->getSelected();

        if (empty($ids)) {
            Session::flash('error', __('No customers selected for sending gifts'));
            return;
        }


        $this->dispatch('sendGifts', $ids);
    }
}
