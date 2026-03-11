<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Form Builder')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Form Builder')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <livewire:dashboard.general.form.form-builder :category="$this->category" />
            </div>

            <div class="mt-3 mb-3">
                <h4>@lang('Form Preview')</h4>
            </div>

            <div class="col-md-12">
                <livewire:dashboard.general.form.form-render :form="$this->category->form" />
            </div>

         </div>

    </div>

    </div>
