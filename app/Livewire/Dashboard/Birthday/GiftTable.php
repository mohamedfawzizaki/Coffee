<?php

namespace App\Livewire\Dashboard\Birthday;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class GiftTable extends BaseTable
{
    protected $actionDisplay = ['show', 'delete'];

    protected $route         = 'dashboard.gift';

    protected $model         = Order::class;

    public function builder(): Builder
    {
        return $this->model::query()->where('type', 'gift')->where('created_by', 'admin')
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

            Column::make(__('Send By'), 'admin_id')
                ->format(function ($value, $column, $row) {
                    return $this->nameWithAvatar($column->admin?->name, $column->admin?->image,  '');
                })
                ->searchable()
                ->sortable(),

            Column::make(__('Send To'), 'send_to')
                ->format(function ($value, $column, $row) {
                    return $this->nameWithImage($column->sendTo->name, $column->sendTo->image,  '/dashboard/customer/show/'.$column->sendTo->id);
                })
                ->searchable()
                ->sortable(),

                Column::make(__('Expire Date'), 'expire_date')
                ->format(function ($value, $column, $row) {
                    return $column->expire_date->format('d-m-Y');
                })
                ->searchable()
                ->sortable(),

            Column::make(__('Title'), 'title')
                ->searchable()
                ->sortable(),

            Column::make(__('Message'), 'message')
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

            Column::make(__('Status'), 'status')
                ->format(function ($value, $column, $row) {
                    return  $column->status;
                })
                ->sortable(),

            Column::make(__('Actions'), 'id')
                ->format(function ($value, $column, $row) {
                    return $this->action($column);
                }),
        ];
    }

}
