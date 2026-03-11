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

            <div class="col-md-6">

            <div class="card custom-card">

                <div class="card-header justify-content-between">
                    <div class="card-title"> @lang('Create Category') </div>
                </div>

                <div class="card-body">


                <form wire:submit.prevent="createCategory">

                    <div class="modal-body">


                        @foreach ($locales as $locale)


                        <div class="mb-3">
                                <label for="{{ $locale }}_title" class="form-label">@lang($locale . '.title')</label>
                                <input wire:model="{{ $locale }}.title" type="text" id="{{ $locale }}_title" class="form-control translated-input" placeholder="@lang($locale . '.title')" required />
                                @error($locale.'.title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        @endforeach


                        <div class="mb-3">
                            <label for="image" class="form-label">@lang('Image')</label>
                            <input type="file" wire:model="newImage" class="form-control" id="image" accept="image/*">
                            @error('newImage') <span class="text-danger">{{ $message }}</span> @enderror

                            @isset($image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($image) }}" alt="Current" class="rounded" style="max-width: 100px">
                                </div>
                            @endisset

                        </div>



                    </div>

                    <div class="modal-footer">
                         <button type="submit" class="btn btn-primary"> @lang('Save')  </button>
                    </div>

                </form>

            </div>

        </div>

     </div>

    </div>

  </div>
