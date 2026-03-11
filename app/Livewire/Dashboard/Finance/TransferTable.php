<?php

namespace App\Livewire\Dashboard\Finance;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Customer;
use App\Models\Customer\Transfer;
use App\Models\Provider\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TransferTable extends BaseTable
{
    protected $actionDisplay = ['show', 'delete'];

    protected $route         = 'dashboard.transfer';

    public $model            = Transfer::class;

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



            Column::make(__('Admin'), 'admin_id')->format(function ($value, $column, $row) {
                return $column->admin?->name;
            })->html()->searchable()->sortable(),

            Column::make(__('Amount'), 'amount')->searchable()->sortable(),

            Column::make(__('Image'), 'image')->format(fn ($value, $column, $row) => $value ? '<img src="' . asset($value) . '" width="50" height="50">' : '')->html()->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

        ];
    }
}
