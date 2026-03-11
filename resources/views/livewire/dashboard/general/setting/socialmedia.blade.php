<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

        <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-facebook-fill me-1"></i>
                @lang('Facebook')
            </label>
        <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="form-password" placeholder="" wire:model="facebook">
        @error('facebook') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-twitter-fill me-1"></i>
                @lang('Twitter')
            </label>
        <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="form-password" placeholder="" wire:model="twitter">
        @error('twitter') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-instagram-line me-1"></i>
                @lang('Instagram')
            </label>
        <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="form-password" placeholder="" wire:model="instagram">
        @error('instagram') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>




    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-linkedin-fill me-1"></i>
                @lang('LinkedIn')
            </label>
        <input type="text" class="form-control @error('linkedin') is-invalid @enderror" id="form-password" placeholder="" wire:model="linkedin">
        @error('linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-tiktok-fill me-1"></i>
                @lang('TikTok')
            </label>
        <input type="text" class="form-control @error('tiktok') is-invalid @enderror" id="form-password" placeholder="" wire:model="tiktok">
        @error('tiktok') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-youtube-fill me-1"></i>
                @lang('YouTube')
            </label>
        <input type="text" class="form-control @error('youtube') is-invalid @enderror" id="form-password" placeholder="" wire:model="youtube">
        @error('youtube') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
        <button class="btn btn-primary" wire:click="save">@lang('Save')</button>
    </div>
    
</div>
