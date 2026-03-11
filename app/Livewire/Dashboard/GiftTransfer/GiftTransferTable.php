<?php

namespace App\Livewire\Dashboard\GiftTransfer;

use App\Livewire\Dashboard\BaseTable;
use App\Models\Gift\Gift;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;

class GiftTransferTable extends BaseTable
{
    public $enableBulk = false;

    protected $actionDisplay = [];

    protected $route         = 'dashboard.gifttransfer';

    protected $model         = Gift::class;

    public function builder(): Builder
    {
        return $this->model::query()
            ->with(['sender', 'receiver'])
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

            Column::make(__('Sender'), 'sender_id')
                ->format(function ($value, $row, Column $column) {
                    $sender = $row->sender;
                    if (!$sender) {
                        return '-';
                    }

                    return '<div class="d-flex align-items-center">'
                        . '<img src="' . e($sender->image) . '" alt="" class="avatar-xs rounded-circle object-cover me-2">'
                        . '<a href="' . e(route('dashboard.customer.show', $sender->id)) . '" class="link-dark" wire:navigate>' . e($sender->name) . '</a>'
                        . '</div>';
                })
                ->html()
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('sender', function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Sender Phone'), 'sender_id')
                ->format(function ($value, $row, Column $column) {
                    return $row->sender->phone ?? '-';
                })
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('sender', function ($query) use ($term) {
                        $query->where('phone', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Receiver'), 'receiver_id')
                ->format(function ($value, $row, Column $column) {
                    $receiver = $row->receiver;
                    if (!$receiver) {
                        return '-';
                    }

                    return '<div class="d-flex align-items-center">'
                        . '<img src="' . e($receiver->image) . '" alt="" class="avatar-xs rounded-circle object-cover me-2">'
                        . '<a href="' . e(route('dashboard.customer.show', $receiver->id)) . '" class="link-dark" wire:navigate>' . e($receiver->name) . '</a>'
                        . '</div>';
                })
                ->html()
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('receiver', function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Receiver Phone'), 'receiver_id')
                ->format(function ($value, $row, Column $column) {
                    return $row->receiver->phone ?? '-';
                })
                ->searchable(function (Builder $builder, $term) {
                    $builder->orWhereHas('receiver', function ($query) use ($term) {
                        $query->where('phone', 'like', '%' . $term . '%');
                    });
                })
                ->sortable(),

            Column::make(__('Amount'), 'amount')
                ->searchable()
                ->sortable(),

            Column::make(__('Created At'), 'created_at')
                ->format(function ($value, $row, Column $column) {
                    return optional($row->created_at)->format('d-m-Y') ?? '-';
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
