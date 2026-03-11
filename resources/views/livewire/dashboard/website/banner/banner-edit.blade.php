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
                        <div class="card-title"> @lang('Edit Banner') </div>
                    </div>

                    <div class="card-body">


                        <form wire:submit.prevent="updateBanner">

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="newArImage" class="form-label">@lang('Arabic Image')</label>
                                    <input type="file" wire:model="newArImage" class="form-control" id="newArImage"
                                        accept="image/*">
                                    @error('newArImage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @if ($newArImage)
                                        <div class="mt-2">
                                            <label class="form-label text-success">@lang('New Image Preview')</label>
                                            <img src="{{ $newArImage->temporaryUrl() }}" alt="New" class="rounded"
                                                style="max-width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @elseif ($ar_image)
                                        <div class="mt-2">
                                            <label class="form-label">@lang('Current Image')</label>
                                            <img src="{{ $ar_image }}" alt="Current" class="rounded"
                                                style="max-width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <span class="text-success" wire:target="newArImage" wire:loading>
                                        @lang('Uploading...')
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label for="newEnImage" class="form-label">@lang('English Image')</label>
                                    <input type="file" wire:model="newEnImage" class="form-control" id="newEnImage"
                                        accept="image/*">
                                    @error('newEnImage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    @if ($newEnImage)
                                        <div class="mt-2">
                                            <label class="form-label text-success">@lang('New Image Preview')</label>
                                            <img src="{{ $newEnImage->temporaryUrl() }}" alt="New" class="rounded"
                                                style="max-width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @elseif ($en_image)
                                        <div class="mt-2">
                                            <label class="form-label">@lang('Current Image')</label>
                                            <img src="{{ $en_image }}" alt="Current" class="rounded"
                                                style="max-width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <span class="text-success" wire:target="newEnImage" wire:loading>
                                        @lang('Uploading...')
                                    </span>
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
                                    wire:target="newArImage,newEnImage,link"> @lang('Save') </button>
                                <span class="text-success" wire:target="newArImage,newEnImage,link" wire:loading>
                                    @lang('Uploading...')
                                </span>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
