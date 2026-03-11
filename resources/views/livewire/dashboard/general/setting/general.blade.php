<div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

    <div class="mb-3">
        <label for="form-text" class="form-label fs-14 text-dark">
            <i class="ri-building-line me-1"></i>
            @lang('Website Title')
        </label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="form-text" placeholder=""
            wire:model="title">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">
            <i class="ri-phone-line me-1"></i>
            @lang('Phone Number')
        </label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="form-password"
            placeholder="" wire:model="phone">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">
            <i class="ri-whatsapp-line me-1"></i>
            @lang('Whatsapp Number')
        </label>
        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="form-password"
            placeholder="" wire:model="whatsapp">
        @error('whatsapp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">
            <i class="ri-mail-line me-1"></i>
            @lang('Email')
        </label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="form-password"
            placeholder="" wire:model="email">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">
            <i class="ri-map-pin-line me-1"></i>
            @lang('Address')
        </label>
        <input type="text" class="form-control @error('address') is-invalid @enderror" id="form-password"
            placeholder="" wire:model="address">
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">
            <i class="ri-image-line me-1"></i>
            @lang('Website Logo')
        </label>
        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="form-password"
            data-allowed-file-extensions="png jpg jpeg" data-default-file="" placeholder="" wire:model="logo">
        @error('logo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <span wire:loading wire:target="logo" class="text-success">
            @lang('Loading...')
        </span>

        @isset($logo)
            @if (is_string($logo))
                <img src="{{ $logo }}" alt="Category Image" class="mt-2" style="max-width: 100px;">
            @else
                <img src="{{ $logo->temporaryUrl() }}" alt="Category Image" class="mt-2" style="max-width: 100px;">
            @endif
        @endisset

    </div>


    <div class="mb-3">
        <label for="form-password" class="form-label fs-14 text-dark">
            <i class="ri-image-2-line me-1"></i>
            @lang('Favicon')
        </label>
        <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="form-password"
            data-allowed-file-extensions="png jpg jpeg" data-default-file="" placeholder="" wire:model="favicon">
        @error('favicon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <span wire:loading wire:target="favicon" class="text-success">
            @lang('Loading...')
        </span>

        @isset($favicon)
            @if (is_string($favicon))
                <img src="{{ $favicon }}" alt="Category Image" class="mt-2" style="max-width: 100px;">
            @else
                <img src="{{ $favicon->temporaryUrl() }}" alt="Category Image" class="mt-2" style="max-width: 100px;">
            @endif
        @endisset


    </div>

    <div class="mb-3">
        <button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled"
            wire:target="logo,favicon">@lang('Save')</button>
    </div>
</div>
