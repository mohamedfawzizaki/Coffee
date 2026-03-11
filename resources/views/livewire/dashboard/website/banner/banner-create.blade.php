<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Banners')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Banners')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Create Banner') </div>
                    </div>

                    <div class="card-body">

                        <form wire:submit.prevent="createBanner">

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="ar_image" class="form-label">@lang('Arabic Image')</label>
                                    <input type="file" wire:model="ar_image" class="form-control" id="ar_image"
                                        accept="image/*">
                                    @error('ar_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @isset($ar_image)
                                        <div class="mt-2">
                                            <img src="{{ $ar_image->temporaryUrl() }}" alt="Current" class="rounded"
                                                style="max-width: 100px">
                                        </div>
                                    @endisset

                                </div>

                                <div class="mb-3">
                                    <label for="en_image" class="form-label">@lang('English Image')</label>
                                    <input type="file" wire:model="en_image" class="form-control" id="en_image"
                                        accept="image/*">
                                    @error('en_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @isset($en_image)
                                        <div class="mt-2">
                                            <img src="{{ $en_image->temporaryUrl() }}" alt="Current" class="rounded"
                                                style="max-width: 100px">
                                        </div>
                                    @endisset

                                </div>

                                <div class="mb-3">
                                    <label for="link" class="form-label">@lang('Link')</label>
                                    <input type="text" wire:model="link" class="form-control" id="link"
                                        placeholder="@lang('Link')">
                                    @error('link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="ar_image,en_image,link"> @lang('Save') </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
