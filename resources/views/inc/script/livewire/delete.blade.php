<button onclick="confirmDelete({{ $id }})" aria-label="button" type="button" class="btn-sm btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-line"></i></button>

@once
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('js')
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: '{{ __("You wont be able to revert this!") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("Yes, delete it!") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteConfirmed', { id: id });
            }
        });
    }
    </script>
@endpush
@endonce
