<?php

namespace App\Livewire\Dashboard\Finance\Coupon;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Finance\Coupon;
use App\Models\Service\Category\Scategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CouponTable extends BaseTable
{
    protected $permissionName = 'finance';
    protected $actionDisplay = ['edit', 'delete'];

    protected $route = 'dashboard.coupon';

    protected $model = Coupon::class;

    public function builder(): Builder
    {
        return $this->model::query()
            ->when($this->getAppliedFilterWithValue('status') || $this->getAppliedFilterWithValue('status') == '0', function ($query) {
                $query->whereStatus($this->getAppliedFilterWithValue('status'));
            })
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [
                    Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00',
                    Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59'
                ]);
            });
    }

    public function columns(): array
    {
        return [

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('code', 'code')->searchable()->sortable(),

            Column::make('Amount', 'amount')
                ->format(function ($value, $column, $row) {
                    return ($column->type == 'fixed') ? $value : $value . ' %';
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make('Max Discount', 'max_discount_amount')
                ->searchable()
                ->sortable(),

            Column::make('Max Usage', 'max_usage')
                ->searchable()
                ->sortable(),

            Column::make('Max Usage Per User', 'max_usage_per_user')
                ->searchable()
                ->sortable(),

            Column::make('Expire Date', 'expire_date')
                ->searchable()
                ->sortable(),

            Column::make('Min Order Amount', 'min_order_amount')
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
                    return $this->active($value, $column);
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
        return [

            SelectFilter::make(__('Status'))
            ->options([
                ''  => __('All'),
                '1' => __('Active'),
                '0' => __('Inactive'),
            ])
            ->filter(function(Builder $builder, string $value) {

                if ($value === '1') {

                    $builder->where('status', true);

                } elseif ($value === '0') {

                    $builder->where('status', false);
                }
            })

        ];
    }



}
