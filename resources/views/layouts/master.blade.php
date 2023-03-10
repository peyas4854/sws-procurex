<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Procurex is a super flexible, powerful, clean &amp; modern cloud based Procurement management application with unlimited possibilities.">

    <meta name="author" content="SmartWebSource">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title') | {{ __(config('app.name')) }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="apple-touch-icon" sizes="180x180" href="/app-assets/images/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/app-assets/images/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/app-assets/images/ico/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700"
          rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css"
          href="/app-assets/vendors/css/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/toastr/toastr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/toastr.css">
    <!--<link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">-->
    <!-- END: Theme CSS-->
    <!-- Flag Icon -->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/flag-icon.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/wizard.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
    <!-- Plugin css -->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/vue-multiselect/vue-multiselect.min.css">

    @yield('style')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu navbar-sticky 2-columns   footer-static  " data-open="hover"
      data-menu="horizontal-menu" data-col="2-columns">

<div id="app">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed bg-primary navbar-brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="img-fluid mx-auto d-block" style="max-height: 35px;"
                             src="{{ asset('assets/images/logo-app-header.png') }}"
                             alt="{{ __(config('app.name')) }}">
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle"
                                                                        href="#"><i class="bx bx-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">

                            @can('setting',\App\Models\Menu::class)
                                <li class="nav-item d-none d-lg-block">
                                    <a class="nav-link" href="{{ url('settings') }}" data-toggle="tooltip"
                                       data-placement="top" title="Basic Settings">
                                        <i class="ficon bx bx-wrench"></i>
                                    </a>
                                </li>
                            @endcan

                                @can('usersList',\App\Models\Menu::class)
                                <li class="nav-item d-none d-lg-block"><a class="nav-link"
                                          href="{{ url('users') }}"
                                          data-toggle="tooltip" data-placement="top"
                                          title="Manage Users & Permissions"><i
                                            class="ficon bx bx-user-check"></i></a>

                                </li>
                                @endcan


                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right d-flex align-items-center">

                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i>
                                <span class="badge badge-pill badge-danger badge-up"> {{ $notification_count }}
                                    </span>
                            </a>
                            @include('layouts.notification-cart')
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
                               data-toggle="dropdown">
                                <div class="user-nav d-lg-flex d-none">
                                        <span class="user-name">
                                            {{ auth()->user()->employee->full_name ?? (auth()->user()->username ?? 'Undefined!') }}
                                        </span>
                                    <span class="user-status">
                                            @if(auth()->user()->employee)
                                            {{ auth()->user()->employee->designation_id ? auth()->user()->employee->designation->name : 'N/A' }}
                                            |
                                            {{ auth()->user()->employee->department_id ? auth()->user()->employee->department->name : '' }}
                                        @else
                                            {{ auth()->user()->type ? ucfirst(auth()->user()->type) :'N/A' }}
                                        @endif
                                        </span>


                                </div>
                                {{--                                     <span><img class="round" src="{{ asset(''.$profile_photo) }}" alt="avatar" height="40" width="40"></span> --}}
                                {{--                                     <span><img class="round" src="/assets/images/default-avatar-{{ $employee->gender ? $employee->gender : 'male'}}.png"alt="avatar" height="40" width="40"></span>--}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                                <!--<a class="dropdown-item" href="#"><i class="bx bx-user mr-50"></i>Edit Profile</a>-->
                                <!-- <a class="dropdown-item" href="#"><i class="bx bx-user mr-50"></i>My Profile</a>
                        <a class="dropdown-item" href="#"><i class="bx bx-user mr-50"></i>Edit Profile Photo</a> -->
                                {{-- <a class="dropdown-item" href="{{ url('profile/edit-profile') }}"><i class="bx bx-user mr-50"></i>Edit Profile</a> --}}
                                <!-- <a class="dropdown-item" href="{{ url('change-password') }}"><i class="bx bx-user mr-50"></i>Change Password</a> -->
                                <div class="dropdown-divider mb-0"></div>
                                <!-- <a class="dropdown-item" href="#"><i class="bx bx-lock mr-50"></i> Logoff</a> -->
                                <a class="dropdown-item" href="{{ url('/change-password') }}"><i
                                        class="bx bx-user mr-50"></i> Change Password</a>
                                <a class="dropdown-item" href=""
                                   onclick="event.preventDefault()
                                                     document.getElementById('logout-form').submit();"><i
                                        class="bx bx-power-off mr-50"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('layouts.main-menu')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">@yield('content_header')</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i
                                                class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a>
                                    </li>
                                    @for ($i = 1; $i <= count(Request::segments()); $i++)
                                        @if (($i < count(Request::segments())) & ($i > 1))
                                            <li class="breadcrumb-item active">
                                        @else
                                            <li class="breadcrumb-item">
                                                @endif
                                                @if (\Request::is('tickets/*'))
                                                    <a
                                                        href="{{ URL::to(implode('/', array_slice(Request::segments(), 0, $i, true))) }}">{{ ucfirst(str_replace('-', ' ', shorten_urlSegment(Request::segment($i)))) }}</a>
                                                @else
                                                    <a
                                                        href="#">{{ ucfirst(str_replace('-', ' ', shorten_urlSegment(Request::segment($i)))) }}</a>
                                                @endif
                                            </li>
                                            @endfor
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                {!! session()->get('message') !!}

                @yield('content')

                <!-- Delete ALERT MODAL -->
                @include('global-modal.delete-alert')
                <!-- Delete ALERT MODAL END -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span
                class="float-left d-inline-block">{{ Carbon\Carbon::now()->format('Y') }} &copy;
                    {{ config('app.name') }}</span><span class="float-right d-sm-inline-block d-none">Crafted with<i
                    class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase"
                                                                          href="{{ config('app.url') }}"
                                                                          target="_blank">{{ config('app.name') }}</a></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i
                    class="bx bx-up-arrow-alt"></i></button>
        </p>
    </footer>

</div>
<!-- END: Footer-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- BEGIN: Vendor JS-->
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
<script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
<script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
<script src="/app-assets/vendors/js/toastr/toastr.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.full.js"></script> --}}
<script src="/app-assets/vendors/js/moment/moment.js"></script>
<script src="/app-assets/vendors/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/app-assets/vendors/js/daterangepicker/daterangepicker.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/scripts/configs/horizontal-menu.js"></script>
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<script src="/app-assets/js/scripts/components.js"></script>
<script src="/app-assets/js/scripts/footer.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="/app-assets/js/scripts/forms/wizard-steps.js"></script>
<!-- END: Page JS-->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>


<script>
    var BASE_URL = "{{ url('/') }}";
    var JS_DATE_FORMAT = "{{ $jsDateFormat }}";
    console.log('JS_DATE_FORMAT', JS_DATE_FORMAT);
    window.APP_URL = "{{ url('/') }}";
</script>
<script src="/assets/js/script.js"></script>

<script>


    $(document).ready(function (e) {
        // Auto logoff call

        //fetch jobs count


        var start = moment().subtract(29, 'days');
        var end = moment();
        let range_format;

        //convert format to raw JS format that this date range plugin support
        if (JS_DATE_FORMAT == "dd M, yyyy") {
            range_format = "DD MMM, YYYY";
        } else if (JS_DATE_FORMAT == "dd-M-yyyy") {
            range_format = "DD-MMM-YYYY";
        } else {
            range_format = "YYYY-MM-DD";
        }
        $(".daterange").daterangepicker({
            "alwaysShowCalendars": true,
            autoUpdateInput: false,
            locale: {
                format: range_format,
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
            },
        });
        $('input[name="date_filter"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format(range_format) + ' - ' + picker.endDate.format(range_format));
        });
        $('input[name="date_filter"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    });
</script>

<script>
    $(document).ready(function () {

        // On click search icon to show or hide search input
        $('#showHideSearch').click(function () {

            $(".js-empolyee-search-ajax").val('').trigger('change');

            if ($(this).html() == '<i class="ficon bx bx-search-alt"></i>') {
                $(this).html('<i class="ficon bx bx-x"></i>');
            } else {
                $(this).html('<i class="ficon bx bx-search-alt"></i>');
            }
            $("#search_box").animate({
                width: "toggle"
            });
        });


        // On select employee go to employee details page
        $(".js-empolyee-search-ajax").on('select2:select', function (e) {
            var employee = e.params.data;
            window.open("{{ URL::to('employee') }}" + '/' + employee.encrypted_id, '_blank');
        });

        // Get Employee Full name with code.


        // Search for employee with select2
        var $ajax = $(".js-empolyee-search-ajax");
        var base_url = window.location.origin;

        // Format select options
        function formatRepo(repo) {

            if (repo.loading) return repo.text;

            var profile_photo = repo.profile_photo != null ? base_url + '/' + repo.profile_photo : base_url +
                '/assets/images/avater.jpg';

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'><img src='" + profile_photo + "' /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + fullnameWithCode(repo.first_name, repo
                    .middle_name, repo.last_name, repo.code) + "</div>";

            if (repo.employee_role && repo.employee_role.length != 0 && repo.employee_role["name"] !==
                'undefined' && repo.employee_role.name != null) {
                markup += "<div class='select2-result-repository__description'>" + repo.employee_role.name +
                    "</div>";
            }

            markup += "<div class='select2-result-repository__statistics'>";

            if (repo.phone != null) {
                markup += "<div class='select2-result-repository__forks'>Phone : " + repo.phone + "</div>" +
                    "<br>";
            }
            if (repo.email != null) {
                markup += "<div class='select2-result-repository__stargazers'>Email : " + repo.email +
                    " </div>" +
                    "<br>";
            }
            if (repo.department && repo.department.length != 0 && repo.department["name"] !== 'undefined' &&
                repo.department.name != null) {
                markup += "<div class='select2-result-repository__watchers'>Department : " + repo.department
                        .name + "</div>" +
                    "<br>";
            }
            if (repo.location && repo.location.length != 0 && repo.location["name"] !== 'undefined' && repo
                .location.name != null) {
                markup += "<div class='select2-result-repository__watchers'>Location : " + repo.location.name +
                    "</div>" +
                    "<br>";
            }
            if (repo.division && repo.division.length != 0 && repo.division["name"] !== 'undefined' && repo
                .division.name != null) {
                markup += "<div class='select2-result-repository__stargazers'>Division : " + repo.division
                    .name + "</div>";
                "<br>";
            }
            if (repo.supervisor && repo.supervisor.length != 0) {
                markup += "<div class='select2-result-repository__stargazers'>Supervisor : " + fullnameWithCode(
                    repo.supervisor.first_name, repo.supervisor.middle_name, repo.supervisor.last_name, repo
                        .supervisor.code) + "</div>";
            }

            markup += "</div>" +
                "</div></div>";

            return markup;
        }

        // Intial Select option
        function formatRepoSelection(repo) {
            return fullnameWithCode(repo.first_name ?? null, repo.middle_name ?? null, repo.last_name ?? null,
                repo.code ?? null) || repo.text;
        }

        // Get Employee Data.

    })
</script>
@yield('script')

</body>
<!-- END: Body-->

</html>
