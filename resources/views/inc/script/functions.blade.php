<script>
    function getRegions(name, city, value = null) {
        if (city) {
            var route = '{{ route('dashboard.cities.regions', ':id') }}';
            route = route.replace(':id', city);
            $.ajax({
                url: route,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'GET',
                },
                success: function(response) {
                    let element = '[name="' + name + '"]';
                    $(element).empty();
                    $(element).append('<option></option');
                    $.each(response, function(id, value) {
                        $(element).append(`<option value='${id}'>${value}</option>`);
                    });
                    $(element).val(value);
                }
            });
        }
    }

    function getUsers(type, value = null) {
        if (type) {
            var route = '{{ route('dashboard.marketings.users') }}';
            $.ajax({
                url: route,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'GET',
                    type: type,
                },
                success: function(response) {
                    let element = '[name="user"]';
                    $(element).empty();
                    $(element).append('<option></option');
                    $.each(response, function(id, value) {
                        $(element).append(`<option value='${id}'>${value}</option>`);
                    });
                    $(element).val(value);
                }
            });
        }
    }
</script>
