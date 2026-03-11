<?php

namespace App\Livewire\Dashboard\Point;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PointTable extends BaseTable
{
    protected $actionDisplay = [];

    protected $route         = 'dashboard.point';

    public $model            = Point::class;

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

            Column::make(__('Customer'), 'customer_id')->format(function ($value, $column, $row) {
                return  $this->nameWithAvatar($column->customer->name, $column->customer->image, route('dashboard.customer.show', $column->customer_id));
            })->searchable(function (Builder $builder, $term) {
                $builder->orWhereHas('customer', function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%');
                });
            })->sortable(),

            Column::make(__('Phone'), 'customer_id')->format(function ($value, $column, $row) {
                return $column->customer->phone ?? '-';
            })->searchable(function (Builder $builder, $term) {
                $builder->orWhereHas('customer', function ($query) use ($term) {
                    $query->where('phone', 'like', '%' . $term . '%');
                });
            })->sortable(),

            Column::make(__('Point'), 'point')->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

        ];
    }
}
