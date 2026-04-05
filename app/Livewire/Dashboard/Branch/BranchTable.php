<?php

namespace App\Livewire\Dashboard\Branch;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Branch\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BranchTable extends BaseTable
{
    protected $permissionName = 'setting';
    protected $actionDisplay = ['show', 'edit'];

    protected $route         = 'dashboard.branch';

    public $model            = Branch::class;

    public function builder(): Builder
    {
        return $this->model::query()->withoutGlobalScope('active')->withTranslation()
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

            Column::make(__('Orders'), 'id')->format(function ($value, $column, $row) {
                return $column->orders->count();
            })->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

            Column::make(__('Status'), 'status')->format(function ($value, $column, $row) {
               return $this->active($value, $column);
            })->sortable(),

            Column::make(__('Actions'), 'id')->format(function ($value, $column, $row) {
                return $this->action($column);
            }),

        ];
    }

    #[On('echo:my-channel,App\\Events\\FlutterEvent')]
    public function onBranchStatusUpdated($data)
    {
        if (isset($data['type']) && $data['type'] === 'branch_status_updated') {
            $this->dispatch('refresh');
        }
    }
}
