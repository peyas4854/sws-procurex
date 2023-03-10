<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">-->
        <title> @yield("title")</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--<link rel="stylesheet" type="text/css" href="/cdn/mis-custom-icon/css/mis-taka.css">-->

        @include("layouts.print.style")

        @yield('style')
    </head>
    <body>
        <div id="container">
            @yield('logo')
            @if(isset($header) && $header === true)
                <div id="header">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{ url('assets/images/print-logo.png') }}" />
                                </td>
                                <td class="text-right">
                                    <h3>{{ config("app.name") }}</h3>
                                    <span>{{ config("app.address") }}</span>
                                    <br />
                                    <span>{{ config("app.phone") }}</span> | <span>{{ config("app.website") }}</span> | <span>{{ config("app.email") }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                </div>
            @endif

            <div class="content">

                {{-- <div class="text-center"><h3>{{ config("app.name") }}</h3></div> --}}

                @yield("content")
            </div>

            <div id="footer">
                @yield("footer")
            </div>

        </div>

        <script>
            window.print();
        </script>
    </body>
</html>
