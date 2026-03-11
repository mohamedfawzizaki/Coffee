<?php

namespace App\Livewire\Dashboard\Unregistered;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\UnregisteredCustomer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UnregisteredCustomerTable extends BaseTable
{
    protected $actionDisplay = [];

    protected $route         = 'dashboard.unregisteredcustomer';

    public $model            = UnregisteredCustomer::class;

    public function builder(): Builder
    {
        return $this->model::query()
            ->when($this->getAppliedFilterWithValue('status') !== null, function ($query) {
                $query->where('status', $this->getAppliedFilterWithValue('status'));
            })
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00', Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59']);
            });
    }

    public function columns(): array
    {
        return [

            Column::make(__('ID'), 'id')->searchable()->sortable(),

            Column::make(__('Name'), 'name')->format(function ($value, $column, $row) {
                return $column->name ?? '-';
             })->html()->searchable()->sortable(),

            Column::make(__('Phone'), 'phone')->searchable()->sortable(),

            Column::make(__('Email Address'), 'email')->searchable()->sortable(),

            Column::make(__('Points'), 'points')->searchable()->sortable(),

            Column::make(__('Orders'), 'orders')->searchable()->sortable(),

            Column::make(__('Total Spent'), 'total_spent')->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

        ];
    }
}
