<!DOCTYPE html>
<html lang="en">
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>
    
   
    <title>club-cms</title>
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
                    <a class="{{ Request::is('cdc/dashboard') ? 'active' : '' }}" href="{{route('cdc.dashboard')}}">
                        Dashboard
                    </a>
                </li>
               
                <li>
                    <a class="{{ Request::is('cdc/slider') ? 'active' : '' }}" href="{{route('cdc.slider')}}" >Slider</a>
                </li>
                <li>
                    <a class="{{ Request::is('cdc/event') ? 'active' : '' }}" href="{{route('cdc.event')}}">Events</a>
                </li>
                <li>
                    <a class="{{ Request::is('cdc/news_activities') ? 'active' : '' }}" href="{{route('cdc.news_activities')}}">News/Activities</a>
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