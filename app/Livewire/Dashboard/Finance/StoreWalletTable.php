<?php

namespace App\Livewire\Dashboard\Finance;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Customer;
use App\Models\Provider\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StoreWalletTable extends BaseTable
{
    protected $actionDisplay = ['show', 'delete'];

    protected $route         = 'dashboard.customer';

    public $model            = Store::class;

    public function builder(): Builder
    {
        return $this->model::query()->where('wallet', '>', 0)
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00', Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59']);
            });
    }

    public function columns(): array
    {
        return [

            Column::make(__('ID'), 'id')->searchable()->sortable(),

            Column::make(__('Title'), 'id')->format(function ($value, $column, $row) {
                return $this->nameWithImage($column->title, $column->logo, $column->id);
            })->html()->searchable()->sortable(),

            Column::make(__('Wallet'), 'wallet')->searchable()->sortable(),
        ];
    }
}
