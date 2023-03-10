@php
//current date
$dt = Carbon\Carbon::now();
$mynotifications = auth()
    ->user()
    ->unreadNotifications->take(10);
@endphp
<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
    <li class="dropdown-menu-header">
        <div class="dropdown-header px-1 py-75 d-flex justify-content-between">
            <span class="notification-title">{{ auth()->user()->notifications->count() }} Notifications</span>
            <span class="text-bold-400 cursor-pointer">
                <a style="color:white;" href="{{ url('mark-as-read') }}">
                    Mark all as read
                </a>
            </span>
        </div>
    </li>
    <li class="scrollable-container media-list">
        @foreach ($mynotifications as $notification)
            @php
                $url = '#';
                if (!empty($notification->data['url'])) {
                    $url = "{$notification->data['url']}?ref={$notification->id}";
                }
            @endphp

            <a class="d-flex justify-content-between" href="{{ $url }}">
                <div class="media d-flex align-items-center">
                    <div class="media-left pr-0">

                        <div class="avatar mr-1 m-0"><img src="{{ isset($notification->data["profile_photo"]) ? asset($notification->data["profile_photo"]) : asset('/assets/images/avater.jpg') }}" alt="avatar" height="39" width="39"></div>

                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">
                            <span class="text-bold-500">{{ $notification->data['subject'] }}</span>
                        </h6>
                        <small class="notification-text">
                            {{-- {{ \App\Helpers\Parser::parseDate($notification->created_at) }} --}}
                            {{ Carbon\Carbon::parse($notification->created_at)->format('d-M-Y') }}
                            -
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </a>
      @endforeach
   <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="{{ route('user.notifications') }}">Read all notifications</a></li>
    {{-- <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="#">Read all notifications</a></li> --}}

</ul>
