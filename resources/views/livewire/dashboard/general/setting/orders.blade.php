    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">

        <div class="mb-3">

            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-map-pin-distance-line me-1"></i>
                @lang('Branch Distance')
                <span class="text-muted fs-12">
                    @lang('The distance between the branch and the customer in kilometers')
                </span>
            </label>

            <input type="number" class="form-control @error('distance') is-invalid @enderror" id="form-password"
                placeholder="" wire:model="distance" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
            @error('distance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <div class="mb-3">

            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-money-dollar-circle-line me-1"></i>
                @lang('Daily Login Points')
                <span class="text-muted fs-12">
                    @lang('The amount of points customer get when login daily')
                </span>
            </label>

            <input type="number" class="form-control @error('daily_login_points') is-invalid @enderror"
                id="form-password" placeholder="" wire:model="daily_login_points" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
            @error('daily_login_points')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">

            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-money-dollar-circle-line me-1"></i>
                @lang('Friend Invitation Points')
                <span class="text-muted fs-12">
                    @lang('The amount of points customer get when invite a friend')
                </span>
            </label>

            <input type="number" class="form-control @error('friend_invitation_points') is-invalid @enderror"
                id="form-password" placeholder="" wire:model="friend_invitation_points" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
            @error('friend_invitation_points')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>


        <div class="mb-3">

            <label for="form-password" class="form-label fs-14 text-dark">
                <i class="ri-money-dollar-circle-line me-1"></i>
                @lang('First Register Points')
                <span class="text-muted fs-12">
                    @lang('The amount of points customer get when register for the first time')
                </span>
            </label>

            <input type="number" class="form-control @error('first_register_point') is-invalid @enderror"
                id="form-password" placeholder="" wire:model="first_register_point" @if(!auth('admin')->user()->isAbleTo('setting-update')) readonly @endif>
            @error('first_register_point')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>


        @if(auth('admin')->user()->isAbleTo('setting-update'))
        <div class="mb-3">
            <button class="btn btn-primary" wire:click="save">@lang('Save')</button>
        </div>
        @endif

    </div>
