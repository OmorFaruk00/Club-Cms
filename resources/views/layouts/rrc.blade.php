<!DOCTYPE html>
<html lang="en">
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>


    <title>Club-Central Management System</title>
    <style>

    </style>
</head>

<body>
    <x-top-nav></x-top-nav>
    <div id="wrapper" style="margin-top: 70px">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a class="{{ Request::is('rrc/dashboard') ? 'active' : '' }}" href="{{ route('rrc.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a class="{{ Request::is('rrc/slider') ? 'active' : '' }}"
                        href="{{ route('rrc.slider') }}">Slider</a>
                </li>
                <li>
                    <a class="{{ Request::is('rrc/about') ? 'active' : '' }}" href="{{ route('rrc.about') }}">About
                        Us</a>
                </li>
                <li>
                    <a class="{{ Request::is('rrc/event') ? 'active' : '' }}"
                        href="{{ route('rrc.event') }}">Events</a>
                </li>
                <li>
                    <a class="{{ Request::is('rrc/team') ? 'active' : '' }}" href="{{ route('rrc.team') }}">Team
                        Member</a>
                </li>
                <li>
                    <a class="{{ Request::is('rrc/news_activities') ? 'active' : '' }}"
                        href="{{ route('rrc.news_activities') }}">Objectives/Activities</a>
                </li>


            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div id="app">
                    @yield('content')
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="{{ asset('js/ckeditor.js') }}"></script>





</body>

</html>
