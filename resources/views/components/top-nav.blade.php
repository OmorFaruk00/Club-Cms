<div class="top-nav fixed-top">
    <div class="d-flex justify-content-between mx-5">
        <a href="#" class=" btn-default menu-toggle"><img id="logo" src="/image/menu.png" alt="menu"></a>
        <a href="{{route('app')}}" class="top-head"> Club - Central Management System</a>
        <a href="#menu-toggle" class=" " id="dropdownMenuButton2" data-bs-toggle="dropdown"
            aria-expanded="false"><img id="logo" src="/image/user3.png" alt="menu"></a>
        <ul class="dropdown-menu dropdown-menu-white mt-3 text-center" aria-labelledby="dropdownMenuButton2">
            <img src="/image/user.png" alt="" class="log-img">
            <div class="mt-3">
                <h6>Omor Faruk</h6>
                <p>User</p>
                <form action="{{ route('logout') }}" method="POST">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn-logout">Logout</button>
              </form>
            </div>
        </ul>
  
    </div>
  </div>