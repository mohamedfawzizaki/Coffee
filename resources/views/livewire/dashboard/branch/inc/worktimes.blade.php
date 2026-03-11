    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <div id="addWorktimeContainer">

        @php
            $noWorkDays = [];

            $days = [
                'monday' => __('Monday'),
                'tuesday' => __('Tuesday'),
                'wednesday' => __('Wednesday'),
                'thursday' => __('Thursday'),
                'friday' => __('Friday'),
                'saturday' => __('Saturday'),
                'sunday' => __('Sunday'),
            ];

            $workDays = $branch->worktimes->pluck('day')->toArray();

            foreach ($days as $day => $name) {
                if (!in_array($day, $workDays)) {
                    $noWorkDays[$day] = $name;
                }
            }
        @endphp

        <div class="row">

            <div class="col-md-4">
                <div class="card mt-4">

                    <div class="card-header">
                        <h5 class="card-title">@lang('Add Worktime')</h5>
                    </div>

                    <div class="card-body">

                        <form wire:submit="addWorktime">
                            <div class="row">



                                <div class="col-md-12 mb-3">
                                    <label for="day">@lang('Day')</label>
                                    <select class="form-control" wire:model="day">
                                        <option value="">@lang('Select Day')</option>
                                        @foreach ($noWorkDays as $day => $name)
                                            <option value="{{ $day }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('day')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model.live="all_day"
                                            id="all_day">
                                        <label class="form-check-label" for="all_day">
                                            @lang('All Day')
                                        </label>
                                    </div>
                                </div>

                                @if (!$all_day)
                                    <div class="col-md-6 mb-3">
                                        <label for="from">@lang('From')</label>
                                        <input type="time" class="form-control" wire:model="from">
                                        @error('from')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="to">@lang('To')</label>
                                        <input type="time" class="form-control" wire:model="to">
                                        @error('to')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        @lang('Add Worktime')
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>
            </div>

            @if ($edit_worktime_mode)
                <div class="col-md-4">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="ri-edit-line me-2"></i>
                                @lang('Edit Worktime')
                            </h5>
                        </div>

                        <div class="card-body">
                            <form wire:submit.prevent="updateWorktime">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_worktime_day">@lang('Day')</label>
                                        <select class="form-control" wire:model="edit_worktime_day">
                                            <option value="">@lang('Select Day')</option>
                                            @foreach ($noWorkDays as $day => $name)
                                                <option value="{{ $day }}">{{ $name }}</option>
                                            @endforeach

                                        </select>
                                        @error('edit_worktime_day')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.live="edit_worktime_all_day" id="edit_all_day">
                                            <label class="form-check-label" for="edit_all_day">
                                                @lang('All Day')
                                            </label>
                                        </div>
                                    </div>

                                    @if (!$edit_worktime_all_day)
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_worktime_from">@lang('From')</label>
                                            <input type="time" class="form-control" wire:model="edit_worktime_from">
                                            @error('edit_worktime_from')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="edit_worktime_to">@lang('To')</label>
                                            <input type="time" class="form-control" wire:model="edit_worktime_to">
                                            @error('edit_worktime_to')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-success" type="submit" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="updateWorktime">
                                                    <i class="ri-save-line me-1"></i>
                                                    @lang('Update Worktime')
                                                </span>
                                                <span wire:loading wire:target="updateWorktime">
                                                    <i class="ri-loader-4-line me-1 spin"></i>
                                                    @lang('Updating...')
                                                </span>
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                                wire:click="cancelEditWorktime">
                                                <i class="ri-close-line me-1"></i>
                                                @lang('Cancel')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-{{ $edit_worktime_mode ? '4' : '8' }}">

                <div class="card mt-4">

                    <div class="card-header">
                        <h5 class="card-title">@lang('Worktimes')</h5>
                    </div>

                    <div class="card-body">

                        @if ($branch->worktimes->count() > 0)

                            <div class="table-responsive">

                                <table class="table align-middle mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('Day')</th>
                                            <th scope="col">@lang('Time')</th>
                                            <th scope="col">@lang('Status')</th>
                                            <th scope="col">@lang('Created At')</th>
                                            <th scope="col">@lang('Actions')</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($branch->worktimes as $index => $worktime)
                                            <tr wire:key="worktime-{{ $worktime->id }}">

                                                <td><a href="#" class="fw-semibold">#{{ $index + 1 }}</a>
                                                </td>

                                                <td>{{ ucfirst(__($worktime->day)) }}</td>

                                                <td>
                                                    @if ($worktime->all_day)
                                                        <span
                                                            class="badge bg-success">{{ $worktime->formatted_time }}</span>
                                                    @else
                                                        {{ $worktime->formatted_time }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($worktime->status)
                                                        <span class="badge bg-success">@lang('Available')</span>
                                                    @else
                                                        <span class="badge bg-danger">@lang('Unavailable')</span>
                                                    @endif
                                                </td>

                                                <td>{{ $worktime->created_at->format('d/m/Y') }}</td>

                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            wire:click="editWorktime({{ $worktime->id }})"
                                                            title="@lang('Edit')">
                                                            <i class="ri-pencil-line"></i>
                                                        </button>

                                                        <button
                                                            class="btn btn-outline-{{ $worktime->status ? 'warning' : 'success' }} btn-sm"
                                                            wire:click="toggleWorktimeStatus({{ $worktime->id }})"
                                                            title="{{ $worktime->status ? __('Make Unavailable') : __('Make Available') }}">
                                                            <i
                                                                class="ri-{{ $worktime->status ? 'eye-off' : 'eye' }}-line"></i>
                                                        </button>

                                                        <button class="btn btn-outline-danger btn-sm"
                                                            wire:click="deleteWorktime({{ $worktime->id }})"
                                                            wire:confirm="@lang('Are you sure you want to delete this worktime?')"
                                                            title="@lang('Delete')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>
                        @else
                            @include('inc.nodata')

                        @endif

                    </div>

                </div>

            </div>




        </div>
    </div>
