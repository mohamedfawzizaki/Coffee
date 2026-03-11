<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Edit Review')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Edit Review')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Edit Review') </div>
                    </div>

                    <form wire:submit="updateReview">

                    <div class="card-body">


                                <div class="mb-3">
                                    <label for="rating" class="form-label">@lang('Rating')</label>
                                    <select class="form-select" wire:model="rating">
                                        <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1 @lang('Star')</option>
                                        <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2 @lang('Stars')</option>
                                        <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3 @lang('Stars')</option>
                                        <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4 @lang('Stars')</option>
                                        <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5 @lang('Stars')</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="comment" class="form-label">@lang('Comment')</label>
                                    <textarea class="form-control" wire:model="comment" rows="3"></textarea>
                                </div>


                    </div>

                    <div class="card-footer border-top-0">
                        <button type="button" class="btn btn-primary" wire:click="updateReview">@lang('Save Changes')</button>
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
