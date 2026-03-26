<?php

namespace App\Livewire\Dashboard\PosManger;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Branch\BranchManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PosMangerTable extends BaseTable
{
    protected $permissionName = 'setting';
    protected $actionDisplay = ['edit', 'delete'];

    protected $route = 'dashboard.posmanager';

    protected $model = BranchManager::class;

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

            Column::make(__('ID'), 'id')
                ->searchable()
                ->sortable(),

            Column::make(__('Name'), 'name')
                ->searchable()
                ->sortable(),

            Column::make(__('Image'), 'image')
                ->format(function ($value, $column, $row) {
                    return $this->image($value);
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make(__('Branch'), 'branch_id')
                ->format(function ($value, $column, $row) {
                    return $column->branch?->title;
                })
                ->searchable()
                ->sortable(),

            Column::make(__('Email'), 'email')
                ->searchable()
                ->sortable(),

            Column::make(__('Phone'), 'phone')
                ->searchable()
                ->sortable(),

            Column::make(__('Created At'), 'created_at')
                ->format(function ($value, $column, $row) {
                    return $column->created_at->format('d-m-Y');
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make(__('Actions'), 'id')
                ->format(function ($value, $column, $row) {
                    return $this->action($column);
                }),
        ];
    }

}
