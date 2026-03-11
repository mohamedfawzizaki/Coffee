<div class="page-content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Create Product')</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.') }}" wire:navigate>@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Create Product')</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <form wire:submit="createCoupon">

            <div class="row">

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Coupon Details')</h5>
                        </div>


                        <div class="card-body">


                            <div class="mb-3">
                                    <label for="code" class="form-label">@lang('Coupon Code')</label>
                                    <input wire:model="code" type="text" id="code" class="form-control" placeholder="@lang('Coupon Code')" />
                                    @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <p class="text-muted mb-2"> @lang('Select Coupon Type')</p>

                                <select class="form-select" id="choices-category-input" wire:model.live="type">

                                    <option value="fixed">{{ __('Fixed') }}</option>

                                    <option value="percentage">{{ __('Percentage') }}</option>

                                </select>

                                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Coupon amount')</label>
                                <input wire:model="amount" type="number" min="1" step="1" id="code" class="form-control" placeholder="@lang('Coupon amount')" />
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Min Order Amount')</label>
                                <input wire:model="min_order_amount" type="number" min="1" step="1" id="code" class="form-control" placeholder="@lang('Min Order Amount')" />
                                @error('min_order_amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Max Discount Amount')</label>
                                <input wire:model="max_discount_amount" type="number" min="1" step="1" id="code" class="form-control" placeholder="@lang('Max Discount Amount')" />
                                @error('max_discount_amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Max Usage')</label>
                                <input wire:model="max_usage" type="number" min="1" step="1" id="code" class="form-control" placeholder="@lang('Max Usage')" />
                                @error('max_usage') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Max Usage Per User')</label>
                                <input wire:model="max_usage_per_user" type="number" min="1" step="1" id="code" class="form-control" placeholder="@lang('Max Usage Per User')" />
                                @error('max_usage_per_user') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Expire Date')</label>
                                <input wire:model="expire_date" type="date" id="code" class="form-control" placeholder="@lang('Expire Date')" />
                                @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>




                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success w-sm">@lang('Save Coupon')</button>
                        </div>
                    </div>



                    </div>


            </div>

        </form>

    </div>

</div>
