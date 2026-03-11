<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Terms & Conditions')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Terms & Conditions')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">


            <div class="col-xl-6">

                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            @lang('Terms & Conditions')
                        </div>
                    </div>

                    <form wire:submit.prevent="saveContentAndSaveTerms" id="terms-form">

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach ($locales as $locale)
                                <div class="mb-3" wire:ignore>
                                    <label for="{{ $locale }}_content"
                                        class="form-label">@lang($locale . '.content')</label>
                                    <div>
                                        <textarea wire:model="{{ $locale }}.content" id="{{ $locale }}_content" class="form-control editor"
                                            placeholder="@lang($locale . '.content')" required></textarea>
                                    </div>
                                    @error($locale . '.content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach


                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit"> @lang('Save') </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        function initSummernote() {
            $('.editor').each(function() {
                let editorId = $(this).attr('id');
                let locale = editorId.split('_')[0]; // Extract locale from the ID

                let $editor = $(this);

                // Destroy existing instance if it exists
                try {
                    if ($editor.next('.note-editor').length > 0) {
                        $editor.summernote('destroy');
                    }
                } catch (e) {
                    // Editor not initialized yet, continue
                }

                $editor.summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript', 'size']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview']],
                        ['style', ['style']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['style', ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']]
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set(locale + '.content', contents);
                        },
                        onInit: function() {
                            // Set initial content if it exists
                            let initialContent = @this.get(locale + '.content');
                            if (initialContent) {
                                $editor.summernote('code', initialContent);
                            }
                        }
                    }
                });
            });
        }

        $(document).ready(function() {
            initSummernote();

            // Handle form submission - save content before submit
            $('#terms-form').on('submit', function(e) {
                e.preventDefault();

                // Get content from all editors
                let arContent = $('#ar_content').summernote('code');
                let enContent = $('#en_content').summernote('code');

                // Call the save method with content
                @this.call('saveContentAndSaveTerms', arContent, enContent);
            });
        });

        // Re-initialize editors on Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            // Clean up existing instances
            $('.editor').each(function() {
                try {
                    if ($(this).next('.note-editor').length > 0) {
                        $(this).summernote('destroy');
                    }
                } catch (e) {
                    // Editor not initialized yet, continue
                }
            });

            // Re-initialize
            initSummernote();
        });
    </script>
@endpush
