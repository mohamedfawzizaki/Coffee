<?php

namespace App\Livewire\Dashboard\Gift;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Branch\Branch;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class GiftTable extends BaseTable
{
    protected $permissionName = 'marketing';
    protected $actionDisplay = ['show', 'delete'];

    protected $route         = 'dashboard.gift';

    protected $model         = GiftOrder::class;

    public function builder(): Builder
    {
        return $this->model::query()->with(['branch', 'customer'])->where('created_by', 'customer')
            ->when($this->getAppliedFilterWithValue('status') || $this->getAppliedFilterWithValue('status') == '0', function ($query) {
                $query->whereStatus($this->getAppliedFilterWithValue('status'));
            })
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [
                    Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00',
                    Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59'
                ]);
            })
            ->when($this->getAppliedFilterWithValue('branch'), function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            });
    }

    public function columns(): array
    {
        return [

            Column::make(__('ID'), 'id')
                ->searchable()
                ->sortable(),

            Column::make(__('Customer'), 'customer_id')
                ->format(function ($value, $column, $row) {
                    return $this->nameWithImage($column->customer->name, $column->customer->image, $column->customer->id, 'dashboard.customer');
                })
                ->html()
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('customer', function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Phone'), 'customer_id')
                ->format(function ($value, $column, $row) {
                    return $column->customer->phone ?? '-';
                })
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('customer', function ($query) use ($term) {
                        $query->where('phone', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Send To'), 'send_to')
                ->format(function ($value, $column, $row) {
                    return $this->nameWithImage($column->sendTo->name, $column->sendTo->image, $column->sendTo->id, 'dashboard.customer');
                })
                ->html()
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('sendTo', function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Branch'), 'branch_id')
                ->format(function ($value, $column, $row) {
                    return  $column->branch?->title;
                })
                ->searchable()
                ->sortable(),

            Column::make(__('Price'), 'total')
                ->format(function ($value, $column, $row) {
                    return '<ul class="list-unstyled">
                        <li>'.__('Total').': '.$column->total.'</li>
                        <li>'.__('Discount').': '.$column->discount.'</li>
                        <li>'.__('Tax').': '.$column->tax.'</li>
                        <li>'.__('Grand Total').': '.$column->grand_total.'</li>
                    </ul>';
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make(__('Created At'), 'created_at')
                ->format(function ($value, $column, $row) {
                    return $column->created_at->format('d-m-Y');
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make(__('Status'), 'status')
                ->format(function ($value, $column, $row) {
                    return  $column->status;
                })
                ->sortable(),

            Column::make(__('Actions'), 'id')
                ->format(function ($value, $column, $row) {
                    return $this->action($column);
                }),
        ];
    }

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            SelectFilter::make(__('Branch'), 'branch')
                ->options(
                    ['' => __('All')] + Branch::query()->withTranslation()->get()->pluck('title', 'id')->toArray()
                )
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('branch_id', $value);
                }),
        ]);
    }

}
