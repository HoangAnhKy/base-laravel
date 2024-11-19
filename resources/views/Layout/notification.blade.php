@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif


@if( session()->has("success") )
    <div class="alert alert-success">
        {{ session()->get("success") }}
    </div>
@endif


@if( session()->has("error") )
    <div class="alert alert-danger">
        {{ session()->get("error") }}
    </div>
@endif

<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div id="alert-container" class="m-3"></div>
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto" style="height: 200px; border: none;" id="notification-content">
                <ul class="list-group" id="notification-list">
                    @if(!empty($list_notification))
                        @foreach($list_notification as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-center notification-read"
                                data-notification_id="{{ $notification->id }}" style="cursor: pointer">
                                {{ $notification->messenger ?? "" }}
                                @if($notification->status === UNREAD)
                                    <span class="badge bg-primary rounded-pill">New</span>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary">View Full</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@push("js")

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        Pusher.logToConsole = false;

        var pusher = new Pusher('9d0c4a69c464e0fef453', {
            cluster: 'ap1',
            authEndpoint: '/broadcasting/auth', // private
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Nếu cần thiết, gửi CSRF token
                }
            }
        });

        // var channel = pusher.subscribe('my-channel');
        var channel = pusher.subscribe('private-App.Models.User.{{ auth()->user()->id }}');

        channel.bind('my-event', function (data) {
            //     alert(data.message);
            changeNotification(data);
        });

        const changeNotification = (data) => {
            data = JSON.parse(data.message);
            let block_count = $("#count-notification");
            let block_messenger = $("#notification-list");

            let count = parseInt(block_count.text());
            block_count.text(count + 1);

            const html_messenger = `
                <li class="list-group-item d-flex justify-content-between align-items-center notification-read"
                    data-notification_id="${data.user_id}" style="cursor: pointer">
                    ${data.messenger}
                    <span class="badge bg-primary rounded-pill">New</span>
                </li>
            `;
            block_messenger.prepend(html_messenger);
            addEventReadNotification();
        }

        function showAlertError(message) {
            let alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            $("#alert-container").html(alertHtml);
        }

        function addEventReadNotification() {
            $(".notification-read").click(function (e) {
                let notificationId = $(this).data("notification_id");

                $.ajax({
                    url: "{{ route('api-read-notification') }}",
                    method: "GET",
                    data: {
                        id: notificationId
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            window.location.href = response.link;
                        }
                    },
                    error: function (xhr, status, error) {
                        let response = JSON.parse(xhr.responseText);
                        showAlertError(response.messenger || "An error occurred");

                    }
                });
            })
        }
        $(document).ready(function () {
            addEventReadNotification();
        })
    </script>
@endpush
