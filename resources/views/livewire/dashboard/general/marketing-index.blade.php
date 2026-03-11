<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Marketing')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Marketing')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            @lang('Marketing')
                        </div>
                    </div>
                    <form wire:submit="sendNotification">

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <div class="mb-3">

                                <label for="type" class="form-label fs-14 text-dark">@lang('type')</label>

                                <select class="form-control" id="type" wire:model="type"
                                    wire:change="changeType($event.target.value)">

                                    <option value="new_customers"> @lang('New Customers') </option>

                                    <option value="customers"> @lang('Customers') </option>

                                    <option value="has_abandoned_carts"> @lang('Has Abandoned Carts') </option>

                                </select>

                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            @if ($selected_type == 'customers')

                                <div id="customers-container">

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" wire:model.live="all_customers" type="checkbox"
                                            value="1" id="all_customers">
                                        <label class="form-check-label" for="all_customers">
                                            @lang('All Customers')
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fs-14 text-dark">@lang('Customers')</label>

                                        @if ($all_customers)
                                            <div class="alert alert-info py-2 mb-0">
                                                {{ app()->getLocale() === 'ar' ? 'سيتم الإرسال لجميع العملاء.' : 'This will be sent to all customers.' }}
                                            </div>
                                        @else
                                            <div class="marketing-select-shell rounded-3 p-2">
                                                <div class="d-flex flex-wrap gap-2 mb-2">
                                                    @forelse ($selectedCustomers as $c)
                                                        <button type="button"
                                                            class="btn btn-sm marketing-chip rounded-pill"
                                                            wire:key="selected-customer-{{ $c->id }}"
                                                            wire:mousedown.prevent="removeCustomer({{ $c->id }})">
                                                            <span class="me-1">{{ $c->name }}</span>
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    @empty
                                                        <span class="text-muted fs-12">
                                                            {{ app()->getLocale() === 'ar' ? 'لم يتم اختيار أي عميل بعد' : 'No customers selected yet' }}
                                                        </span>
                                                    @endforelse
                                                </div>

                                                <input type="text" class="form-control"
                                                    wire:model.live.debounce.300ms="customerSearch" autocomplete="off"
                                                    placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث بالاسم/الهاتف/الإيميل...' : 'Search by name/phone/email...' }}">

                                                <div class="list-group mt-2"
                                                    style="max-height: 240px; overflow: auto;">
                                                    @forelse ($customerSearchResults as $c)
                                                        <button type="button"
                                                            class="list-group-item list-group-item-action marketing-result"
                                                            wire:key="search-customer-{{ $c->id }}"
                                                            wire:mousedown.prevent="addCustomer({{ $c->id }})">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="fw-semibold">{{ $c->name }}</div>
                                                                <div class="text-muted fs-12">{{ $c->phone }}</div>
                                                            </div>
                                                            @if (!empty($c->email))
                                                                <div class="text-muted fs-12">{{ $c->email }}</div>
                                                            @endif
                                                        </button>
                                                    @empty
                                                        @if (!empty($customerSearch))
                                                            <div class="text-muted fs-12 py-2 px-2">
                                                                {{ app()->getLocale() === 'ar' ? 'لا توجد نتائج' : 'No results' }}
                                                            </div>
                                                        @endif
                                                    @endforelse
                                                </div>
                                            </div>

                                            @error('customers_ids')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>

                                </div>

                            @endif

                            <div class="mb-3">
                                <label for="title" class="form-label fs-14 text-dark">@lang('Title')</label>
                                <input type="text" class="form-control" id="title" wire:model="title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="content" class="form-label fs-14 text-dark">@lang('Content')</label>
                                <textarea class="form-control" id="content" rows="5" wire:model="content"></textarea>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{--  <div class="row">

                            <div class="col-md-6">

                            <div class="mb-3">
                                <label for="date" class="form-label fs-14 text-dark">@lang('Date')</label>
                                <input type="date" class="form-control" id="date">
                                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                         </div>
                         <div class="col-md-6">

                        <div class="mb-3">
                            <label for="time" class="form-label fs-14 text-dark">@lang('Time')</label>
                            <input type="time" class="form-control" id="time" >
                            @error('time') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        </div>
                    </div>  --}}


                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit"> @lang('Send Notification') </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        /* Theme-aligned marketing customer picker (Velzon vars with Bootstrap fallbacks) */
        #customers-container .marketing-select-shell {
            background: var(--vz-card-bg-custom, var(--bs-body-bg));
            border: 1px solid var(--vz-border-color, var(--bs-border-color));
        }

        #customers-container .marketing-chip {
            border: 1px solid rgba(var(--vz-primary-rgb, 13, 110, 253), 0.25);
            background: rgba(var(--vz-primary-rgb, 13, 110, 253), 0.12);
            color: var(--vz-primary, var(--bs-primary));
        }

        #customers-container .marketing-chip:hover {
            border-color: rgba(var(--vz-primary-rgb, 13, 110, 253), 0.40);
            background: rgba(var(--vz-primary-rgb, 13, 110, 253), 0.18);
            color: var(--vz-primary, var(--bs-primary));
        }

        #customers-container .marketing-chip:focus {
            box-shadow: 0 0 0 .25rem rgba(var(--vz-primary-rgb, 13, 110, 253), .20);
        }

        /* Results list */
        #customers-container .marketing-result {
            border-radius: 12px;
            margin-bottom: 6px;
            border: 1px solid var(--vz-border-color, var(--bs-border-color));
        }

        #customers-container .marketing-result:hover {
            background: rgba(var(--vz-primary-rgb, 13, 110, 253), 0.06);
        }
    </style>
@endpush
