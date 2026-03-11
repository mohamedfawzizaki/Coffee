<?php

namespace App\Livewire\Dashboard\Order\Abandoned;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Order\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AbandonedTable extends BaseTable
{
    protected $actionDisplay = ['delete'];

    protected $route         = 'dashboard.preorder';

    protected $model         = Cart::class;

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

            Column::make(__('Customer'), 'customer_id')
                ->format(function ($value, $column, $row) {
                    if($column->customer){
                        return $this->nameWithAvatar($column->customer->name, $column->customer->image, '/dashboard/customer/show/'.$column->customer->id);
                    }
                    return __('Deleted Customer');
                })
                ->html()
                ->searchable()
                ->sortable(),


            Column::make(__('Products'), 'id')
                ->format(function ($value, $column, $row) {

                    $items = '';
                    foreach ($column->items as $item) {
                        $items .= '<li>'.$item->product->title.'</li>';
                    }
                    return '<ul class="list-unstyled">'.$items.'</ul>';
                })
                ->html()
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


            // Column::make(__('Actions'), 'id')
            //     ->format(function ($value, $column, $row) {
            //         return $this->action($column);
            //     }),
        ];
    }

}
