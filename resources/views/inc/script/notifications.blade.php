<script>
    // OPEN NOTIFICATIONS
    $('#notificationBtn').on('click', function() {
        buildNotifications();
    });

    // BUILD NOTIFICATIONS
    function buildNotifications() {
        $.ajax({
            url: '{{ route('dashboard.profile.notifications.read') }}',
            type: 'GET',
            data: {
                _method: 'GET',
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                console.log(response)
                if (!response.data.length) {
                    $('#notificationContent').html('<lottie-player class="mx-auto" src="{{ asset('assets/dashboard/plugins/lottie/empty.json') }}" background="transparent" speed="1" style="max-width: 200px;" loop autoplay></lottie-player>');
                    return;
                }
                $('#notificationAlert').empty();
                var html = '';
                response.data.forEach(function(notifyData) {
                    html += '<div class="dropdown-item d-flex text-start">';
                    html += '<div class="me-3 notifyimg bg-primary-gradient brround box-shadow-primary"><i class="bi bi-bell"></i></div>';
                    html += '<div class="mt-1 wd-80p">';
                    html += '<h5 class="notification-label mb-1">' + notifyData.body + '</h5>';
                    html += '<span class="notification-subtext">' + notifyData.date.date + ' ' + notifyData.date.time + '</span>';
                    html += '</div>';
                    html += '</div>';
                });
                $('#notificationContent').html(html);
            }
        });
    }
</script>
