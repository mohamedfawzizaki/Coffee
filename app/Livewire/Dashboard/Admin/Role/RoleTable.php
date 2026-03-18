<?php

namespace App\Livewire\Dashboard\Admin\Role;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Customer;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class RoleTable extends BaseTable
{
    protected $actionDisplay = ['delete', 'edit'];

    protected $route = 'dashboard.role';
    protected $model = Role::class;

    public function builder(): Builder
    {

        $userRoles = auth('admin')->user()->roles()->pluck('id')->toArray();
        return Role::query()->where('id', '!=', 1)
            ->whereNotIn('id', $userRoles)
            ->when($this->getAppliedFilterWithValue('status') || $this->getAppliedFilterWithValue('status') == '0', function ($query) {
                $query->whereStatus($this->getAppliedFilterWithValue('status'));
            })
            ->when($this->getAppliedFilterWithValue('createdAt'), function ($query) {
                $query->whereBetween('created_at', [Str::before($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 00:00:00', Str::after($this->getAppliedFilterWithValue('createdAt'), ' - ') . ' 23:59:59']);
            })
        ;
    }

    public function columns(): array
    {
        return [

            Column::make('ID', 'id')->searchable()->sortable(),

            Column::make('Name', 'name')->searchable()->sortable(),

            Column::make('Created At', 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

            Column::make('Actions', 'id')->format(function ($value, $column, $row) {
                return $this->action($column);
            }),

        ];
    }
}
