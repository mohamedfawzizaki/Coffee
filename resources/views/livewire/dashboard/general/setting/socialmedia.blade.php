<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

        <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-facebook-fill me-1"></i>
                @lang('Facebook')
            </label>
        <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="form-password" placeholder="" wire:model="facebook" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
        @error('facebook') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-twitter-fill me-1"></i>
                @lang('Twitter')
            </label>
        <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="form-password" placeholder="" wire:model="twitter" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
        @error('twitter') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-instagram-line me-1"></i>
                @lang('Instagram')
            </label>
        <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="form-password" placeholder="" wire:model="instagram" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
        @error('instagram') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>




    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-linkedin-fill me-1"></i>
                @lang('LinkedIn')
            </label>
        <input type="text" class="form-control @error('linkedin') is-invalid @enderror" id="form-password" placeholder="" wire:model="linkedin" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
        @error('linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-tiktok-fill me-1"></i>
                @lang('TikTok')
            </label>
        <input type="text" class="form-control @error('tiktok') is-invalid @enderror" id="form-password" placeholder="" wire:model="tiktok" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
        @error('tiktok') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-youtube-fill me-1"></i>
                @lang('YouTube')
            </label>
        <input type="text" class="form-control @error('youtube') is-invalid @enderror" id="form-password" placeholder="" wire:model="youtube" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
        @error('youtube') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    @if(auth('admin')->user()->isAbleTo('setting-update'))
    <div class="mb-3">
        <button class="btn btn-primary" wire:click="save">@lang('Save')</button>
    </div>
    @endif
    
</div>
