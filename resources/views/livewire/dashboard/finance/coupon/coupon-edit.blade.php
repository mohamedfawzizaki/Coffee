<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Edit Coupon')</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.') }}" wire:navigate>@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.coupon.index') }}" wire:navigate>@lang('Coupons')</a></li>
                            <li class="breadcrumb-item active">@lang('Edit Coupon')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit="updateCoupon">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Coupon Details')</h5>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="code" class="form-label">@lang('Coupon Code')</label>
                                <input wire:model="code" type="text" id="code" class="form-control" placeholder="@lang('Enter coupon code')" />
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">@lang('Coupon Type')</label>
                                <select class="form-select" wire:model.live="type">
                                    <option value="fixed">@lang('Fixed Amount')</option>
                                    <option value="percentage">@lang('Percentage')</option>
                                </select>
                                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">@lang('Coupon Amount')</label>
                                <input wire:model="amount" type="number" min="1" step="1" id="amount" class="form-control" placeholder="@lang('Enter coupon amount')" />
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="min_order_amount" class="form-label">@lang('Minimum Order Amount')</label>
                                <input wire:model="min_order_amount" type="number" min="1" step="1" id="min_order_amount" class="form-control" placeholder="@lang('Enter minimum order amount')" />
                                @error('min_order_amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="max_discount_amount" class="form-label">@lang('Maximum Discount Amount')</label>
                                <input wire:model="max_discount_amount" type="number" min="1" step="1" id="max_discount_amount" class="form-control" placeholder="@lang('Enter maximum discount amount')" />
                                @error('max_discount_amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="max_usage" class="form-label">@lang('Maximum Usage')</label>
                                <input wire:model="max_usage" type="number" min="1" step="1" id="max_usage" class="form-control" placeholder="@lang('Enter maximum usage limit')" />
                                @error('max_usage') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="max_usage_per_user" class="form-label">@lang('Maximum Usage Per User')</label>
                                <input wire:model="max_usage_per_user" type="number" min="1" step="1" id="max_usage_per_user" class="form-control" placeholder="@lang('Enter maximum usage per user')" />
                                @error('max_usage_per_user') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="expire_date" class="form-label">@lang('Expiry Date')</label>
                                <input wire:model="expire_date" type="date" id="expire_date" class="form-control" />
                                @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success w-sm">@lang('Update Coupon')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
