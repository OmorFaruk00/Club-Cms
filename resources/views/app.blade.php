@extends('layouts.master')

@section('title', 'home')

@section('content')

<x-top-nav></x-top-nav>

{{-- <div class="top-nav">
  <div class="d-flex justify-content-between mx-5">
      <a href="#" class=" btn-default menu-toggle"><img id="logo" src="/image/menu.png" alt="menu"></a>
      <a href="#menu-toggle" class="top-head"> Club - Central Management System</a>
      <a href="#menu-toggle" class=" " id="dropdownMenuButton2" data-bs-toggle="dropdown"
          aria-expanded="false"><img id="logo" src="/image/user.png" alt="menu"></a>
      <ul class="dropdown-menu dropdown-menu-white mt-3 text-center" aria-labelledby="dropdownMenuButton2">
          <img src="/image/user.png" alt="" class="log-img">
          <div class="mt-3">
              <h6>Omor Faruk</h6>
              <p>user</p>
              <form action="{{ route('logout') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn-logout">Logout</button>
            </form>
          </div>
      </ul>

  </div>
</div> --}}


<div class="bg">

    <div class="row main-content">
      <div class="col-md-3 col-xl-2 col-sm-6">
        <a class="app-link" href="{{route('cdc.dashboard')}}">
          <div class="app">
            <div class="app-icon">
              <img src="image/cdc.png" alt="" />
            </div>
          </div>
          <p class="app-title">CDC</p>
        </a>
      </div>
      <div class="col-md-3 col-xl-2 col-sm-6">
        <a class="app-link" >
          <div class="app">
            <div class="app-icon">
              <img src="image/rrc.png" alt="" />
            </div>
          </div>
          <p class="app-title">RRC</p>
        </a>
      </div>
      <div class="col-md-3 col-xl-2 col-sm-6">
        <a class="app-link" >
          <div class="app">
            <div class="app-icon">
              <img src="image/yec.png" alt="" />
            </div>
          </div>
          <p class="app-title">YEC</p>
        </a>
      </div>
      
      

     
      
    </div>
  </div>

  {{-- <script>
    new Vue({
        el: '#app',
        data: {
            
        },
        methods: {

            logout() {
                axios.get('{{ env('APP_URL') }}/logout')
                    .then(response => {
                        window.location.href = "{{ env('APP_URL') }}";
                    })
                    .catch(error => {
                        console.log(error)
                       
                    });
            },
        },      
    });
</script> --}}

  

@endsection