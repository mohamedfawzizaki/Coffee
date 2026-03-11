<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Edit Customer Card')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Customer Cards')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Edit Customer Card') </div>
                    </div>

                    <div class="card-body">


                        <form wire:submit.prevent="updateCustomerCard">

                            <div class="modal-body">


                                @foreach ($locales as $locale)
                                    <div class="mb-3">
                                        <label for="{{ $locale }}_title"
                                            class="form-label">@lang($locale . '.title')</label>
                                        <input wire:model="{{ $locale }}.title" type="text"
                                            id="{{ $locale }}_title" class="form-control translated-input"
                                            placeholder="@lang($locale . '.title')" required />
                                        @error($locale . '.title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach

                                <div class="mb-3">
                                    <label for="orders_count" class="form-label">@lang('Orders Count')</label>
                                    <input wire:model="orders_count" type="number" id="orders_count"
                                        class="form-control" placeholder="@lang('Orders Count')" required />
                                    @error('orders_count')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">

                                    <label for="form-password" class="form-label fs-14 text-dark">
                                        <i class="ri-money-dollar-circle-line me-1"></i>
                                        @lang('Money to Point')
                                        <span class="text-muted fs-12">
                                            @lang('The amount of money customer spend to get one point')
                                        </span>
                                    </label>

                                    <input type="number"
                                        class="form-control @error('money_to_point') is-invalid @enderror"
                                        id="form-password" placeholder="" wire:model="money_to_point">
                                    @error('money_to_point')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="mb-3">

                                    <label for="form-password" class="form-label fs-14 text-dark">
                                        <i class="ri-money-dollar-circle-line me-1"></i>
                                        @lang('Point')
                                    </label>

                                    <input type="number"
                                        class="form-control @error('point_to_money') is-invalid @enderror"
                                        id="form-password" placeholder="" wire:model="point_to_money">
                                    @error('point_to_money')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label for="image" class="form-label">@lang('Image')</label>
                                    <input wire:model="image" type="file" id="image" class="form-control"
                                        placeholder="@lang('Image')" />

                                    @if ($image)
                                        <div class="mt-2">
                                            <label class="form-label text-success">@lang('New Image Preview')</label>
                                            <img src="{{ $image->temporaryUrl() }}" alt=""
                                                class="img-fluid border rounded"
                                                style="width: 100px; height: 100px; object-fit: cover;" />
                                        </div>
                                    @endif

                                    @if ($customerCard && $customerCard->image)
                                        <div class="mt-2">
                                            <label class="form-label text-muted">@lang('Current Image')</label>
                                            <img src="{{ $customerCard->image }}" alt=""
                                                class="img-fluid border rounded"
                                                style="width: 100px; height: 100px; object-fit: cover;" />
                                        </div>
                                    @endif

                                    <span class="text-success" wire:target="image" wire:loading>
                                        @lang('Uploading...')
                                    </span>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <x-editor model="content" :label="__('Content')" :placeholder="__('Content')" required />

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"> @lang('Save') </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
