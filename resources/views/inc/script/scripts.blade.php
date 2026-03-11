<script>
    // NOTIFICATIONS
    @if (session('alert-message'))
        notif({
            msg: '{{ session('alert-message') }}',
            type: '{{ session('alert-type') }}',
            position: 'bottom',
            autohide: true,
            animation: 'zoom',
        });
    @endif


    @if ($errors->any())

    @foreach ($errors->all() as $error)


          notif({
            msg: '{{ $error }}',
            type: 'error',
            position: 'bottom',
            autohide: true,
            animation: 'zoom',
        });



        @endforeach

    @endif


    // DATE RANGE PICKER
    $('.rangeDatePicker').daterangepicker({
        autoUpdateInput: false,
        opens: 'center',
        drops: 'auto',
        showDropdowns: true,
        autoApply: true,
        locale: {
            @if (LaravelLocalization::getCurrentLocale() == 'ar')
                direction: 'rtl',
            @endif
            format: "@lang('DD/MM/YYYY')",
            separator: " - ",
            applyLabel: "@lang('Apply')",
            cancelLabel: "@lang('Cancel')",
            fromLabel: "@lang('From')",
            toLabel: "@lang('To')",
            customRangeLabel: "@lang('Custom')",
            weekLabel: "@lang('W')",
            daysOfWeek: [
                "@lang('Su')",
                "@lang('Mo')",
                "@lang('Tu')",
                "@lang('We')",
                "@lang('Th')",
                "@lang('Fr')",
                "@lang('Sa')"
            ],
            monthNames: [
                "@lang('January')",
                "@lang('February')",
                "@lang('March')",
                "@lang('April')",
                "@lang('May')",
                "@lang('June')",
                "@lang('July')",
                "@lang('August')",
                "@lang('September')",
                "@lang('October')",
                "@lang('November')",
                "@lang('December')"
            ],
            firstDay: 6
        },
    });

    // FILE UPLOAD
    $('.dropify').dropify({
        messages: {
            'default': "@lang('Drag And Drop a File Here Or Click')",
            'replace': "@lang('Drag And Drop Or Click To Replace')",
            'remove': "@lang('Remove')",
            'error': "@lang('Ooops , Something Wrong Appended .')",
        },
        error: {
            'fileSize': "@lang('The File Size Is Too Big ( 2M MAX ) .')",
        }
    });
</script>
