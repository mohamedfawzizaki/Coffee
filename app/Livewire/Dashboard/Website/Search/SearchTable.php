<?php
namespace App\Livewire\Dashboard\Website\Search;

use App\Livewire\Dashboard\BaseTable;
use App\Models\General\Search;
use App\Models\Product\Category\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SearchTable extends BaseTable
{
    protected $actionDisplay = ['delete'];

    protected $route = 'dashboard.search';

    protected $model = Search::class;

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

            Column::make(__('Keyword'), 'keyword')
                ->searchable()
                ->sortable(),

            Column::make(__('Customer'), 'customer_id')
                ->format(function ($value, $column, $row) {
                    return $row->customer?->name;
                })
                ->html()
                ->searchable()
                ->sortable(),


            Column::make(__('Ip'), 'ip')
                ->searchable()
                ->sortable(),

            Column::make(__('User Agent'), 'user_agent')
                ->searchable()
                ->sortable(),

            Column::make(__('browser'), 'browser')
                ->searchable()
                ->sortable(),

            Column::make(__('os'), 'os')
                ->searchable()
                ->sortable(),

            Column::make(__('Created At'), 'created_at')
                ->format(function ($value, $column, $row) {
                    return $column->created_at->format('d-m-Y');
                })
                ->html()
                ->searchable()
                ->sortable(),
        ];
    }

}
