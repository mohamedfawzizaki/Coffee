<div class="page-content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Create Product')</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.') }}"
                                    wire:navigate>@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Create Product')</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <form wire:submit.prevent="createProduct" enctype="multipart/form-data">

            <div class="row">

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Product Details')</h5>
                        </div>


                        <div class="card-body">

                            @foreach ($locales as $locale)
                                <div class="mb-3">
                                    <label for="{{ $locale }}_title" class="form-label"><img
                                            src="{{ asset('images/flags/' . $locale . '.svg') }}" alt="{{ $locale }}"
                                            class="me-2 rounded" height="18"> @lang($locale . '.title')</label>
                                    <input wire:model="{{ $locale }}.title" type="text"
                                        id="{{ $locale }}_title" class="form-control"
                                        placeholder="@lang($locale . '.title')" />
                                    @error($locale . '.title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">

                                    <label> <img src="{{ asset('images/flags/' . $locale . '.svg') }}" alt="{{ $locale }}"
                                            class="me-2 rounded" height="18"> @lang($locale . '.content')</label>

                                    <textarea class="form-control" id="ckeditor-classic" wire:model="{{ $locale }}.content"
                                        placeholder="@lang($locale . '.content')"></textarea>
                                    @error($locale . '.content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">

                            <h5 class="card-title mb-0">@lang('Product Prices')</h5>

                        </div>

                        <div class="card-body">

                            <div class="tab-content">

                                <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">

                                    <div class="mb-3">
                                        <label for="choices-publish-status-input"
                                            class="form-label">@lang('Price Type')</label>

                                        <select class="form-select" id="choices-publish-status-input"
                                            wire:model="price_type"
                                            wire:change="onPriceTypeChange($event.target.value)">

                                            <option value="static" @if ($static_price) selected @endif>
                                                @lang('Static Price')</option>
                                            <option value="sizes" @if (!$static_price) selected @endif>
                                                @lang('Size Based Price')</option>

                                        </select>

                                        @error('price_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if ($static_price)

                                        <div class="mb-3">
                                            <label for="datepicker-publish-input"
                                                class="form-label">@lang('Price')</label>
                                            <input type="number" step="0.01" wire:model="price" class="form-control"
                                                placeholder="@lang('Price')">
                                        </div>

                                        <div class="mb-3">
                                            <label for="datepicker-publish-input"
                                                class="form-label">@lang('Cost Price')</label>
                                            <input type="number" step="0.01" wire:model="cost_price" class="form-control"
                                                placeholder="@lang('Cost Price')">
                                        </div>
                                    @else
                                        <div id="product-sizes">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="btn btn-primary float-end d-block mb-3"
                                                        type="button" wire:click="addSize">@lang('Add Size')</button>
                                                </div>
                                            </div>

                                            @foreach ($sizes as $index => $size)
                                                <div class="row mt-3">

                                                    @foreach ($locales as $locale)
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">@lang('Size.' . $locale . '.title')</label>
                                                                <input type="text" class="form-control"
                                                                    wire:model="sizes.{{ $index }}.{{ $locale }}.title"
                                                                    placeholder="@lang('Size.' . $locale . '.title')">
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('Price')</label>
                                                            <div class="input-group has-validation mb-3">
                                                                <span class="input-group-text">$</span>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    wire:model="sizes.{{ $index }}.price"
                                                                    placeholder="@lang('Price')">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('Cost Price')</label>
                                                            <div class="input-group has-validation mb-3">
                                                                <span class="input-group-text">$</span>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    wire:model="sizes.{{ $index }}.cost_price"
                                                                    placeholder="@lang('Cost Price')">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div class="mb-3">
                                                            <label class="form-label">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger d-block"
                                                                wire:click="removeSize({{ $index }})">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    @endif


                                    <div class="mb-3">
                                        <label for="choices-publish-status-input"
                                            class="form-label">@lang('Can Replace')</label>

                                        <select class="form-select" id="choices-publish-status-input"
                                            wire:model="can_replace"
                                            wire:change="onCanReplaceChange($event.target.value)">

                                            <option value="1" @if ($can_replace == 1) selected @endif>
                                                @lang('Yes')</option>
                                            <option value="0" @if ($can_replace == 0) selected @endif>
                                                @lang('No')</option>

                                        </select>

                                        @error('can_replace')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if ($can_replace)
                                        <div class="mb-3">
                                            <label for="choices-publish-status-input"
                                                class="form-label">@lang('Points')</label>
                                            <input type="number" wire:model="points" class="form-control"
                                                placeholder="@lang('Points')">
                                        </div>
                                    @endif


                                </div>



                            </div>

                        </div>

                    </div>

                    <div class="text-end mb-3">
                        <button wire:click="createProduct" type="button" class="btn btn-success w-sm"
                            wire:loading.attr="disabled" wire:target="image,createProduct">
                            <span wire:loading.remove wire:target="createProduct">@lang('Save Product')</span>
                            <span wire:loading wire:target="createProduct">@lang('Saving...')</span>
                        </button>
                    </div>


                </div>

                <div class="col-md-4">

                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Product Category')</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-4">
                                <h5 class="fs-14 mb-1">@lang('Product Category')</h5>
                                <p class="text-muted">@lang('Add Product Category.')</p>

                                <div class="text-center">

                                    <select class="form-select" id="choices-publish-status-input"
                                        wire:model="category_id" wire:change="onCategoryChange($event.target.value)">

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach

                                    </select>

                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Product Images')</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-4">
                                <h5 class="fs-14 mb-1">@lang('Product Image')</h5>
                                <p class="text-muted">@lang('Add Product main Image.')</p>

                                <div class="text-center">

                                    <input class="form-control" type="file"
                                        accept="image/png, image/gif, image/jpeg" wire:model="image">

                                    @if ($image)
                                        <div class="mt-2">
                                            <label class="form-label text-success">@lang('Image Preview')</label>
                                            <img src="{{ $image->temporaryUrl() }}" alt="@lang('Product Image Preview')"
                                                class="img-fluid border rounded"
                                                style="width: 150px; height: 150px; object-fit: cover;" />
                                        </div>
                                    @endif

                                    <span class="text-success" wire:target="image" wire:loading>
                                        @lang('Uploading...')
                                    </span>

                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
