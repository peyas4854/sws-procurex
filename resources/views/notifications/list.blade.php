@extends('layouts.master')

@section('page_title')
    All Notifications
@endsection

@section('content_header')
    All Notifications
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> All Notifications ({{ $myNotifications->total() }}) :
                        {{ request('type') }}</h5>
                    <div class="heading-elements">
                        <a href="{{ url('mark-as-read') }}"
                            onclick="return confirm('Are you sure you want mark all as read?');"
                            class="btn btn-info btn-sm mr-1 mb-1">
                            Mark all as read
                        </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(['route' => 'user.notifications', 'method' => 'GET']) !!}
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <label for="date">Select Date Range</label>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="text" name="date_filter" id="date_filter" class="form-control"
                                        value="{{ request('date_filter') }}" placeholder="Select Date Range"
                                        autocomplete="off">
                                    <div class="form-control-position">
                                        <i class="bx bx-calendar-check"></i>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group">
                                <label for="type">Notification Type</label>
                                <select name="type" class="form-control select2" placeholder="Notification Type">
                                    <option value="">Select-Notification-Type</option>
                                    @foreach ($notification_type as $key => $value)
                                        <option value="{{ $value }}"
                                            {{ $value === request('type') ? 'selected' : '' }}>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-12 form-group input-group">
                                <div class="d-flex  pt-2">
                                    <button class="btn btn-dark" type="submit">Submit</button>
                                </div>
                                <div class="d-flex  pt-2">
                                    <a href="{{ route('user.notifications') }}"
                                        class="btn btn-danger ml-1 float-right">Reset</a>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                        <ul class="list-unstyled">
                            <li class="scrollable-container media-list">
                                @foreach ($myNotifications as $notification)
                                    @php
                                        $url = '#';
                                        if (!empty($notification->data['url'])) {
                                            $url = "{$notification->data['url']}?ref={$notification->id}";
                                        }
                                        $data = json_decode($notification->data);
                                    @endphp
                                    <a class="d-flex justify-content-between" href="{{ $url }}">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar mr-1 m-0">
                                                    <img src="{{ isset($notification->data['profile_photo']) ? asset($notification->data['profile_photo']) : asset('/assets/images/avater.jpg') }}"
                                                        alt="avatar" height="39" width="39">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">
                                                    <span class="text-bold-500">
                                                        {{-- {{ $notification->data['subject'] }} --}}
                                                        {{ $data->subject }}
                                                    </span>
                                                </h6>
                                                <small class="notification-text">
                                                    {{ \App\Helpers\Parser::parseDate($notification->created_at) }}
                                                    - {{ $notification->created_at->diffForHumans() }} 
                                                    {{-- | {{ getNotificationType($notification->type) }} --}}
                                                    | {{ $notification->read_at ? 'Read' : 'Unread' }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </li>
                            <table>
                                <tr>
                                    <td colspan="5">
                                        @if (!empty($myNotifications->pagination_summary))
                                            <span
                                                class="label label-primary">{{ $myNotifications->pagination_summary }}</span>
                                        @endif
                                    </td>
                                    <td colspan="5">
                                        <div class="pull-right">{{ $myNotifications->links() }}</div>
                                    </td>
                                </tr>
                            </table>
                        </ul>
                    </div>
                </div>
            </div>
        @endsection

        @section('script')
            <script type="text/javascript">
                $(function() {
                    $('input[name="date_filter"]').daterangepicker({
                        "alwaysShowCalendars": true,
                        autoUpdateInput: false,
                        locale: {
                            cancelLabel: 'Clear'
                        },
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                'month').endOf('month')]
                        }

                    });

                    $('input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format(range_format) + ' - ' + picker.endDate.format(
                            range_format));
                    });

                    $('input[name="date_filter"]').on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');
                    });

                });
            </script>
        @endsection
