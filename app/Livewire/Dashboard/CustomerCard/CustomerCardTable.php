<?php

namespace App\Livewire\Dashboard\CustomerCard;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Customer;
use App\Models\CustomerCard\CustomerCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CustomerCardTable extends BaseTable
{
    protected $actionDisplay = ['edit', 'delete'];

    protected $permissionName = 'setting';

    protected $route         = 'dashboard.customercard';

    public $model            = CustomerCard::class;

    public function builder(): Builder
    {
        return $this->model::query()->withTranslation()
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

            Column::make(__('Title'), 'id')->format(function ($value, $column, $row) {
                return  $column->title;
            })->html()->searchable()->sortable(),

            Column::make(__('Image'), 'image')->format(function ($value, $column, $row) {
                return $this->image($column->image ?? asset('images/default.png'), $column->title ?? 'Customer Card', $column->id);
            })->html()->searchable()->sortable(),

            Column::make(__('Orders Count'), 'orders_count')->searchable()->sortable(),

            Column::make(__('Money To Point'), 'money_to_point')->searchable()->sortable(),

            Column::make(__('Point To Money'), 'point_to_money')->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

            Column::make(__('Actions'), 'id')->format(function ($value, $column, $row) {
                return $this->action($column);
            }),

        ];
    }
}
