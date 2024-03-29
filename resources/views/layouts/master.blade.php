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
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/axios.min.js') }}"></script>
  <script src="{{ asset('js/vue.js') }}"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
  {{-- <script src="{{ asset('js/ckeditor.js') }}"></script> --}}
  

  <title>Club-Central Management System</title>
</head>

<body>
 

 
  <main>
    <div id='app'>
      @yield('content')
    </div>
  </main>

  
 

</body>

</html>
