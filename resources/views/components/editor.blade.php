@props(['model' => '', 'label' => '', 'placeholder' => '', 'required' => false])

<div class="mb-3" x-data="editorComponent('{{ $model }}')" x-init="init">
    <label for="{{ $model }}" class="form-label">{{ $label }}</label>
    <div wire:ignore>
        <textarea
            wire:model="{{ $model }}"
            id="{{ $model }}"
            class="form-control @error($model) is-invalid @enderror"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            style="min-height: 200px;"
            x-ref="editor"
        ></textarea>
    </div>
    @error($model) <span class="text-danger">{{ $message }}</span> @enderror
</div>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    function editorComponent(model) {
        return {
            editor: null,
            init() {
                this.initEditor();
                this.$watch('$wire.' + model, value => {
                    if (this.editor && this.editor.summernote('code') !== value) {
                        this.editor.summernote('code', value || '');
                    }
                });
            },
            initEditor() {
                const element = this.$refs.editor;
                if (!element) return;

                if (this.editor) {
                    this.editor.summernote('destroy');
                    this.editor = null;
                }

                $(element).summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ],
                    callbacks: {
                        onChange: (contents) => {
                            @this.set(model, contents);
                            element.dispatchEvent(new Event('input'));
                        },
                        onInit: () => {
                            this.editor = $(element);
                            this.editor.summernote('code', @this.get(model) || '');
                        }
                    }
                });

                if (@json($required)) {
                    $(element).on('summernote.change', function() {
                        const content = $(element).summernote('code').trim();
                        if (!content) {
                            element.setAttribute('required', 'required');
                        } else {
                            element.removeAttribute('required');
                        }
                    });
                }
            }
        }
    }

    // Handle navigation events
    document.addEventListener('livewire:navigating', () => {
        const editors = document.querySelectorAll('[x-data^="editorComponent"]');
        editors.forEach(editor => {
            const component = editor.__x.$data;
            if (component.editor) {
                component.editor.summernote('destroy');
                component.editor = null;
            }
        });
    });

    document.addEventListener('livewire:navigated', () => {
        const editors = document.querySelectorAll('[x-data^="editorComponent"]');
        editors.forEach(editor => {
            const component = editor.__x.$data;
            component.initEditor();
        });
    });
</script>
@endpush
