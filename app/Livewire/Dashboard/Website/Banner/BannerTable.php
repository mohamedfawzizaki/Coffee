<?php

namespace App\Livewire\Dashboard\Website\Banner;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Website\Banner\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BannerTable extends BaseTable
{
    protected $actionDisplay = ['edit', 'delete'];

    protected $route = 'dashboard.banner';

    protected $model = Banner::class;

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

            Column::make(__('Ar Image'), 'ar_image')
                ->format(function ($value, $column, $row) {
                    return '<img src="' . $column->ar_image . '" alt="" class="rounded-circle" style="width: 30px; height: 30px;">';
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make(__('En Image'), 'en_image')
                ->format(function ($value, $column, $row) {
                    return '<img src="' . $column->en_image . '" alt="" class="rounded-circle" style="width: 30px; height: 30px;">';
                })
                ->searchable()
                ->html()
                ->sortable(),


            Column::make(__('Link'), 'link')
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

}
