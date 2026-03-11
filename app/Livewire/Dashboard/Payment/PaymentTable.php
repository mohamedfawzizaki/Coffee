<?php

namespace App\Livewire\Dashboard\Payment;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Customer\Customer;
use App\Models\Finance\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PaymentTable extends BaseTable
{
    protected $actionDisplay = ['show', 'delete'];

    protected $route         = 'dashboard.payment';

    public $model            = Payment::class;

    public function builder(): Builder
    {
        return $this->model::query()
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

            Column::make(__('Customer'), 'customer_id')
                ->format(function ($value, $column, $row) {
                    if($column->customer){
                        return $this->nameWithAvatar($column->customer->name, $column->customer->image, '/dashboard/customer/show/'.$column->customer->id);
                    }
                    return __('Deleted Customer');
                })
                ->html()
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('customer', function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Phone'), 'customer_id')
                ->format(function ($value, $column, $row) {
                    return $column->customer->phone ?? '-';
                })
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('customer', function ($query) use ($term) {
                        $query->where('phone', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Amount'), 'amount')->searchable()->sortable(),

           Column::make(__('Payment Method'), 'payment_method')->searchable()->sortable(),

            Column::make(__('Created At'), 'created_at')->format(function ($value, $column, $row) {
                return $column->created_at->format('d-m-Y');
            })->html()->searchable()->sortable(),

            Column::make(__('Status'), 'status')->format(function ($value, $column, $row) {
               return $this->active($value, $column);
            })->sortable(),

        ];
    }
}
