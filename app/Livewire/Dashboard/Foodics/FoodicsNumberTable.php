<?php

namespace App\Livewire\Dashboard\Foodics;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Foodics\BannedNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FoodicsNumberTable extends BaseTable
{
    protected $actionDisplay = ['delete'];

    protected $permissionName = 'setting';

    protected $route         = 'dashboard.foodics-number';

    public $model            = BannedNumber::class;

    #[On('refreshTable')]
    public function refreshTable()
    {
        // This will refresh the table data
    }

    public function builder(): Builder
    {
        return $this->model::query()
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00', Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59']);
            });
    }

    public function columns(): array
    {
        return [

            Column::make(__('ID'), 'id')->searchable()->sortable(),

            Column::make(__('Number'), 'number')->html()->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),


            Column::make(__('Actions'), 'id')->format(function ($value, $column, $row) {
                return $this->action($column);
            }),

        ];
    }
}
