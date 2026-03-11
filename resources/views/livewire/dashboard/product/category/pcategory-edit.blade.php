<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Categories')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Categories')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Edit Category') </div>
                    </div>

                    <form wire:submit="updateCategory">

                    <div class="card-body">


                        @foreach ($locales as $locale)


                        <div class="mb-3">
                                <label for="{{ $locale }}_title" class="form-label">@lang($locale . '.title')</label>
                                <input wire:model="{{ $locale }}.title" type="text" id="{{ $locale }}_title" class="form-control" placeholder="@lang($locale . '.title')" required />
                                @error($locale.'.title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        @endforeach

                        <div class="mb-3">
                            <label for="category-title" class="form-label">@lang('Image')</label>
                            <input type="file" class="form-control" id="category-title" wire:model="image" placeholder="@lang('Image')">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                            <span wire:loading wire:target="image">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                                @isset($image)
                                    @if(is_string($image))
                                        <img src="{{ $image }}" alt="Category Image" class="mt-2" style="max-width: 100px;">
                                    @else
                                        <img src="{{ $image->temporaryUrl() }}" alt="Category Image" class="mt-2" style="max-width: 100px;">
                                    @endif
                                @endisset

                        </div>

                    </div>

                    <div class="card-footer border-top-0">
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">@lang('Update')</button>
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
