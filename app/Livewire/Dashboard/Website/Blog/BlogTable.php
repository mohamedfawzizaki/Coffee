<?php

namespace App\Livewire\Dashboard\Website\Blog;
use App\Livewire\Dashboard\BaseTable;
use App\Models\Website\Blog\Blog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BlogTable extends BaseTable
{
    protected $permissionName = 'blog';
    protected $actionDisplay = ['edit', 'delete', 'show'];

    protected $route = 'dashboard.blog';

    protected $model = Blog::class;

    public function builder(): Builder
    {
        return $this->model::query()->withTranslation()

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

            Column::make(__('Title'), 'id')
                ->format(function ($value, $column, $row) {
                    return $column->title;
                })
                ->searchable()
                ->sortable(),

            Column::make(__('Views'), 'views')
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
