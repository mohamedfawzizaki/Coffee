<?php

namespace App\Livewire\Dashboard\Admin\Admin;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Admin\Admin;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
class AdminTable extends BaseTable
{
    protected $actionDisplay = ['delete', 'edit'];
    protected $permissionName = 'admin';

    protected $route = 'dashboard.admin';

    public $model = Admin::class;

    public function builder(): Builder
    {

        return $this->model::query()->where('id', '!=', 1)->where('id', '!=', auth('admin')->id())
            ->when($this->getAppliedFilterWithValue('status') || $this->getAppliedFilterWithValue('status') == '0', function ($query) {
                $query->whereStatus($this->getAppliedFilterWithValue('status'));
            })
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00', Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59']);
            });
    }

    public function columns(): array
    {
        return [

            Column::make('ID', 'id')->searchable()->sortable(),

            Column::make(__('Name'), 'name')->format(function ($value, $column, $row) {
                return  $this->nameWithAvatar($column->name, $column->image, '');
            })->html()->searchable()->sortable(),
            Column::make('Email', 'email')->searchable()->sortable(),

            Column::make('Role', 'id')->format(function ($value, $column, $row) {
                return $column->roles?->first()?->name;
            })->searchable()->sortable(),

            Column::make('Created At', 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

            Column::make('Status', 'status')->format(function ($value, $column, $row) {
               return $this->active($value, $column);
            })->sortable(),

            Column::make('Actions', 'id')->format(function ($value, $column, $row) {
                return $this->action($column);
            }),

        ];
    }
    public function filters(): array
    {
        $roles = Role::where('id', '!=', 1)
            ->pluck('name', 'id')
            ->toArray();

        return [
            SelectFilter::make(__('Role'))
            ->options([
                null => __('All'),
            ] + $roles + [
            ])
            ->filter(function(Builder $builder, string $value) {
                if ($value === '') {
                    return;
                }

                $builder->whereHas('roles', function ($query) use ($value) {
                    $query->where('id', $value);
                });
            }),

            DateFilter::make(__('Created At From'))
                ->config([
                    'allowInput' => true,
                    'dateFormat' => 'Y-m-d',
                    'placeholder' => __('From date')
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->whereDate('created_at', '>=', $value);
                }),

            DateFilter::make(__('Created At To'))
                ->config([
                    'allowInput' => true,
                    'dateFormat' => 'Y-m-d',
                    'placeholder' => __('To date')
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->whereDate('created_at', '<=', $value);
                }),

            SelectFilter::make(__('Date Range'))
                ->options([
                    ''              => __('All'),
                    'last_week'     => __('Last Week'),
                    'last_month'    => __('Last Month'),
                    'last_year'     => __('Last Year'),
                    'this_year'     => date('Y'),
                    'last_2_years'  => (date('Y')-1),
                    'last_3_years'  => (date('Y')-2),
                    'last_4_years'  => (date('Y')-3),
                    'last_5_years'  => (date('Y')-4),
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'last_week') {
                        $builder->whereBetween('created_at', [
                            now()->subWeek()->startOfWeek(),
                            now()->subWeek()->endOfWeek()
                        ]);
                    } elseif ($value === 'last_month') {
                        $builder->whereBetween('created_at', [
                            now()->subMonth()->startOfMonth(),
                            now()->subMonth()->endOfMonth()
                        ]);
                    } elseif ($value === 'last_year') {
                        $builder->whereBetween('created_at', [
                            now()->subYear()->startOfYear(),
                            now()->subYear()->endOfYear()
                        ]);
                    } elseif (is_numeric($value)) {
                        $builder->whereYear('created_at', $value);
                    }
                }),
        ];
    }

    #[On('filterByStatus')]
    public function filterByStatus($value)
    {
        $this->resetComputedPage();

        if ($value == '' || $value == null) {
            $this->resetFilter('status');
        } else {
            $this->setFilter('status', $value);
        }

        $this->dispatch('refresh');
    }


}
