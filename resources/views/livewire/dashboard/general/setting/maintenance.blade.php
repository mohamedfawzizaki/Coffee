<div class="tab-pane fade" id="v-pills-maintenance" role="tabpanel" aria-labelledby="v-pills-maintenance-tab">

    <div class="mb-3">

        <label for="maintenance" class="form-label fs-14 text-dark">
            <i class="ri-tools-line me-1"></i>
            @lang('Maintenance Mode')
            <span class="text-muted fs-12">
                @lang('Enable maintenance mode to temporarily disable the application')
            </span>
        </label>

        <select class="form-select @error('maintenance') is-invalid @enderror" id="maintenance" wire:model="maintenance" 
            @if(!auth('admin')->user()->isAbleTo('setting-update')) disabled @endif>
            <option value="0">@lang('Disabled')</option>
            <option value="1">@lang('Enabled')</option>
        </select>
        @error('maintenance') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>




@if(auth('admin')->user()->isAbleTo('setting-update'))
<div class="mb-3">
    <button class="btn btn-primary" wire:click="save">@lang('Save')</button>
</div>
@endif

</div>
