<script>
    // RESET FILTERS
    function resetFilters(filterKey = '') {
        if (filterKey == 'active' || filterKey == '') {
            $('[name="active"]').val(null).change();
            Livewire.emit('filterByActive', null);
        }
        if (filterKey == 'createdAt' || filterKey == '') {
            $('[name="createdAt"]').val('');
            Livewire.emit('filterByCreatedAt', null);
        }
    }

    // ACTIVE FILTER
    $('[name="active"]').on('change', function() {
        Livewire.emit('filterByActive', $(this).val());
    });

    // CREATED AT FILTER
    $('[name="createdAt"]').on('apply.daterangepicker', function(ev, picker) {
        var format =
            @if (LaravelLocalization::getCurrentLocale() == 'ar')
                'YYYY/MM/DD'
            @else
                'DD/MM/YYYY'
            @endif ;
        $(this).val(picker.startDate.format(format) + ' - ' + picker.endDate.format(format));
        Livewire.emit('filterByCreatedAt', [
            picker.startDate.format('YYYY-MM-DD'),
            picker.endDate.format('YYYY-MM-DD'),
        ]);
    });
</script>
