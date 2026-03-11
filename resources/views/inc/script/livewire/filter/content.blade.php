<div id="filterCollapse" class="collapse @if (isset(optional(request()->get('table'))['filters'])) show @endif">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-funnel fs-11 me-2"></i>
                @lang('Filters')
            </h3>
            <div class="card-options">
                <button type="button" onclick="resetFilters()" class="btn btn-danger">@lang('Reset Filters')</button>
            </div>
        </div>
        <div class="card-body pb-0 row justify-content-center">
            <div class="col-md-6 mb-5">
                <x-form-select title="Status" name="active" :relation="[1 => 'Active', 0 => 'Inactive']" :value="optional(optional(request()->get('table'))['filters'])['active'] ?? ''" isTranslate="1"></x-form-select>
            </div>
            <div class="col-md-6 mb-5">
                <x-form-date1 title="Created At" name="createdAt" :value="optional(optional(request()->get('table'))['filters'])['createdAt']"></x-form-date1>
            </div>
        </div>
    </div>
</div>
