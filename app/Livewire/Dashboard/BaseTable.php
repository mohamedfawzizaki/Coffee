<?php

namespace App\Livewire\Dashboard;

use App\Models\Administrator\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataTableExport;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class BaseTable extends DataTableComponent
{
    protected $actionDisplay = ['show', 'edit', 'delete'];

    public $enableBulk = true, $orderBy = 'id', $orderType = 'desc', $dbSelect = true;


    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTableAttributes([
            'class' => 'table-hover table-rounded table align-middle table-nowrap mb-0',
        ]);

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });

        $this->setTdAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });

        $this->setFooterTdAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });
        $this->setDefaultSort($this->orderBy, $this->orderType);
        $this->setDefaultSortingLabels(__('Ascending'), __('Descending'));
        if ($this->enableBulk) {
            $this->setBulkActions([
                'exportSelected' => __('Export')
            ]);
        }
        if ($this->dbSelect) {
            $this->setAdditionalSelects('*');
        }
        $this->setPerPageAccepted([10, 25, 50, 100]);
        $this->setPerPage(10);
        $this->setFooterEnabled();
        // $this->setLoadingPlaceholderEnabled();
        // $this->setRefreshVisible();

        $this->setSearchLive();

        $this->setSearchIcon('heroicon-m-magnifying-glass');
    }

    // public function builder(): Builder
    // {
    //     return Role::query();
    // }

    public function columns(): array
    {
        return [];
    }

    protected function image($image, $caption = null, $id = null)
    {
        return view('inc.script.livewire.images')->with([
            'image'   => $image,
            'caption' => $caption,
            'id'      => $id,
        ]);
    }

    protected function active($active, $query)
    {

        return view('inc.script.livewire.active')->with([
            'active' => $active,
            'id' => $query->id,
            'model' => $this->model,
        ]);
    }

    protected function nameWithImage($name, $image, $id, $routeOverride = null)
    {
        return view('inc.script.livewire.name-with-image')->with([
            'name'  => $name,
            'image' => $image,
            'id'    => $id,
            'route' => $routeOverride ?? $this->route,
        ]);
    }


    protected function nameWithAvatar($name, $image, $route = null)
    {
        return view('inc.script.livewire.name-with-avatar')->with([
            'name'  => $name,
            'image' => $image,
            'route' => $route ?? $this->route,
        ]);
    }

    protected function columnWithIcon($column, $icon)
    {
        return view('inc.script.livewire.column-with-icon')->with([
            'column' => $column,
            'icon'   => $icon,
        ]);
    }

    protected function action($query, $extra = '')
    {
        $content = '';

        if(empty($this->actionDisplay) || count($this->actionDisplay) === 0) {
            return;
        }

        if (in_array('show', $this->actionDisplay)) {
            $content .= view('inc.script.livewire.show')->with([
                'route' => $this->route,
                'id'    => $query->id,
            ]);
        }
        if (in_array('edit', $this->actionDisplay)) {
            $content .= view('inc.script.livewire.edit')->with([
                'route' => $this->route,
                'id' => $query->id,
            ]);
        }

        if (in_array('delete', $this->actionDisplay)) {
            $content .= view('inc.script.livewire.delete')->with([
                'route' => $this->route,
                'id'   => $query->id,
            ]);
        }

        if (in_array('restore', $this->actionDisplay)) {
            $content .= view('inc.script.livewire.restore')->with([
                'route' => $this->route,
                'id'    => $query->id,
            ]);
        }


        return view('inc.script.livewire.actions')->with([
            'content' => $content,
            'extra' => $extra,
        ]);
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

                if ($value === null) {
                    return;
                }
                if ($value === '1') {

                    $builder->where('status', true);

                } elseif ($value === '0') {

                    $builder->where('status', false);

                }

            }),

            DateFilter::make(__('Created At From'))
                ->config([
                    'allowInput' => true,
                    'dateFormat' => 'Y-m-d',
                    'placeholder' => __('From date')
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->whereDate('created_at', '>=', $value);
                }),

            DateFilter::make(__('Created At To'))
                ->config([
                    'allowInput' => true,
                    'dateFormat' => 'Y-m-d',
                    'placeholder' => __('To date')
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->whereDate('created_at', '<=', $value);
                }),

            SelectFilter::make(__('Date Range'))
                ->options([
                    ''              => __('All'),
                    'last_week'     => __('Last Week'),
                    'last_month'    => __('Last Month'),
                    'last_year'     => __('Last Year'),
                    'this_year'     => date('Y'),
                    'last_2_years'  => (date('Y')-1),
                    'last_3_years'  => (date('Y')-2),
                    'last_4_years'  => (date('Y')-3),
                    'last_5_years'  => (date('Y')-4),
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'last_week') {
                        $builder->whereBetween('created_at', [
                            now()->subWeek()->startOfWeek(),
                            now()->subWeek()->endOfWeek()
                        ]);
                    } elseif ($value === 'last_month') {
                        $builder->whereBetween('created_at', [
                            now()->subMonth()->startOfMonth(),
                            now()->subMonth()->endOfMonth()
                        ]);
                    } elseif ($value === 'last_year') {
                        $builder->whereBetween('created_at', [
                            now()->subYear()->startOfYear(),
                            now()->subYear()->endOfYear()
                        ]);
                    } elseif (is_numeric($value)) {
                        $builder->whereYear('created_at', $value);
                    }
                }),



            // DateRangeFilter::make(__('Created At'), 'createdAt')
            //     ->setPillsLocale(app()->getLocale())
            //     ->config([
            //         'allowInput'      => true,
            //         'altFormat'       => 'F j, Y',
            //         'ariaDateFormat'  => 'F j, Y',
            //         'dateFormat'      => 'Y-m-d',
            //         'earliestDate'    => '2024-01-01',
            //         'latestDate'      => date('Y-m-d'),
            //         'placeholder'     => __('Enter date range'),
            //         'locale'          => app()->getLocale()
            //     ])
            //     ->filter(function(Builder $builder, array $dateRange) {

            //         if (isset($dateRange['minDate']) && isset($dateRange['maxDate'])) {
            //             $builder->whereDate('created_at', '>=', $dateRange['minDate'])
            //                    ->whereDate('created_at', '<=', $dateRange['maxDate']);
            //         }
            //     }),
        ];
    }

    #[On('filterByStatus')]
    public function filterByStatus($value)
    {
         $this->resetComputedPage();

        if ($value == null) {
            $this->resetFilter('status');
        } else {
            $this->setFilter('status', $value);
        }

        $this->dispatch('refresh');
    }

    #[On('filterByCreatedAt')]
    public function filterByCreatedAt($value)
    {
        $this->resetComputedPage();

        if ($value == null) {
            $this->resetFilter('createdAt');
            return;
        }
        $dateRange = [
            'minDate' => request()->get('table-filters.createdAt.minDate'),
            'maxDate' => request()->get('table-filters.createdAt.maxDate')
        ];

        if ($dateRange['minDate'] && $dateRange['maxDate']) {

            $this->setFilter('createdAt', $dateRange);
        }

        $this->dispatch('refresh');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        if (isset($this->model)) {
            $this->model::find($id)->delete();
            session()->flash('success', __('Deleted successfully'));
        } else {
            session()->flash('error', __('Model not defined'));
        }
    }


    #[On('restoreConfirmed')]
    public function restoreConfirmed($id)
    {
        if (isset($this->model)) {
            $this->model::withTrashed()->find($id)->restore();
            session()->flash('success', __('Restored successfully'));
        } else {
            session()->flash('error', __('Model not defined'));
        }
    }

    public function imageName($image, $name, $link)
    {
        return  '<div class="d-flex align-items-center">
                    <div class="me-2">
                        <span class="avatar avatar-md avatar-rounded">
                            <img src="' . $image . '" alt="">
                        </span>
                    </div>
                    <div class="fw-semibold">
                        <a href="' . $link . '" wire:navigate>' . $name . '</a>
                    </div>
                   </div>';
    }

    public function exportSelected()
    {
        if ($this->getSelectedCount() > 0) {
            // Get the selected IDs
            $selectedRows = $this->getSelected();

            // Query the database for the selected rows
            $rows = $this->builder()
                ->whereIn($this->getPrimaryKey(), $selectedRows)
                ->get();

            // Get visible columns (excluding the actions column)
            $columns = collect($this->columns())
                ->filter(function($column) {
                    return $column->getTitle() !== __('Actions');
                });

            // Generate and download the Excel file
            $filename = class_basename($this->builder()->getModel()) . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            return Excel::download(
                new DataTableExport($rows, $columns),
                $filename
            );
        }
    }

    #[On('toggleStatus')]
    public function toggleStatus($id)
    {
        try {
            $record = $this->model::findOrFail($id);
            $newStatus = !$record->status;
            $record->status = $newStatus;

            // If model is Customer and status is being set to 0 (inactive), logout the customer
            if (get_class($record) === \App\Models\Customer\Customer::class && $newStatus == false) {
                // Clear device token to logout from mobile app
                // This prevents the customer from receiving notifications
                $record->device_token = null;
            }

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
