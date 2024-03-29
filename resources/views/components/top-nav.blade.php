
@php
    $user = Illuminate\Support\Facades\Auth::user()

@endphp

<div class="top-nav fixed-top" id='new_app'>
    <div class="d-flex justify-content-between mx-5">
        <a href="#" class=" btn-default menu-toggle"><img id="logo" src="/image/menu.png" alt="menu"></a>
        <a href="{{route('app')}}" class="top-head"> Club - Central Management System</a>
        <a href="#menu-toggle" class=" " id="dropdownMenuButton2" data-bs-toggle="dropdown"
            aria-expanded="false"><img id="logo" src="/image/user3.png" alt="menu"></a>
        <ul class="dropdown-menu dropdown-menu-white mt-3 text-center" aria-labelledby="dropdownMenuButton2">
            <img src="{{$user->image ?? null}}" alt="" class="profile-img">
            <div class="my-3">
                <h6>{{$user->name ?? null}}</h6>
                <p>{{$user->email ?? null}}</p>
                <form action="{{ route('logout') }}" method="POST">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn-logout">Logout</button>
              </form>
            </div>
            <a href="{{route('setting.change_password')}}" class="btn-change">Change Password</a>
        </ul>
        
    </div>
 
  </div>

