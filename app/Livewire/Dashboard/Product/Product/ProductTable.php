<?php

namespace App\Livewire\Dashboard\Product\Product;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Branch\BranchProduct;
use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ProductTable extends BaseTable
{
    protected $permissionName = 'product';
    protected $actionDisplay = ['show', 'edit', 'delete'];

    protected $route = 'dashboard.product';

    protected $model = Product::class;

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

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Title', 'id')
                ->format(function ($value, $column, $row) {
                    return $column->title ?? '-';
                })
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('translations', function ($query) use ($term) {
                        $query->where('title', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make('Price', 'price')
                ->searchable()
                ->sortable(),

            Column::make('Points', 'points')
                ->format(function ($value, $column, $row) {
                    if($column->can_replace){
                        return $value;
                     }
                     return '<span class="badge bg-danger">'.__('No').'</span>';
                })
                ->html()
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_id')
                ->format(function ($value, $column, $row) {
                    return $column->category->title;
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

            // Column::make(__('Status'), 'status')
            //     ->format(function ($value, $column, $row) {
            //         return $this->active($value, $column);
            //     })
            //     ->sortable(),

            Column::make(__('Points'), 'points')
                ->format(function ($value, $column, $row) {
                     if($column->can_replace){
                        return $value;
                     }
                     return '<span class="badge bg-danger">'.__('No').'</span>';
                })
                ->html()
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
            }),

            SelectFilter::make(__('Category'))
                ->options([
                    '' => __('All'),
                    PCategory::query()->withTranslation()->get()->pluck('title', 'id')->toArray()
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('p_category_id', $value);
                    }
                }),

        ];
    }



    /*
     * Toggle status
     */
    #[On('toggleStatus')]
    public function toggleStatus($id)
    {
        try {
            $record = $this->model::findOrFail($id);
            $newStatus = !$record->status;
            $record->status = $newStatus;

            BranchProduct::where('product_id', $id)->update(['status' => $newStatus]);

            $record->save();

            $this->dispatch('refresh');

            // Add success notification
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => __('Status updated successfully')
            ]);
        } catch (\Exception $e) {
            // Add error notification
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('Error updating status')
            ]);
        }
    }

}