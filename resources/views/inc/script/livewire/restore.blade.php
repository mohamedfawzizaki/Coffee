<button onclick="confirmRestore({{ $id }})" aria-label="button" type="button" class="btn btn-success btn-icon waves-effect waves-light">
    <i class="ri-refresh-line"></i>
</button>

@once
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('js')
    <script>
    function confirmRestore(id) {
        Swal.fire({
            title: 'هل انت متأكد',
            text: 'استعاده الاعلان سوف يظهر في الموقع للعملاء',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم قم بالاستعاده',
            cancelButtonText: 'الغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('restoreConfirmed', { id: id });
            }
        });
    }
    </script>
@endpush
@endonce
