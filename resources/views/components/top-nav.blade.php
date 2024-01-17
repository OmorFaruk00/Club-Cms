<style>
    .top-nav{
        background: #0c93e7;
        height: 70px;
        padding-top: 10px;
    }
    .top-head{
        color: #fff;
        font-size: 30px;
        font-weight: 600;
        text-decoration: none
    }
    .top-head:hover{
        color: #fff;
        
    }
    .dropdown-menu{
        height: 300px;
        width: 250px;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        border: none;
        
    }
    .log-img{
        height: 100px;
        margin-top: 20px
    }
    .btn-logout{
        background: rgb(175 15 15);
    padding: 10px 73px;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 20px;
    font-weight: 600;
    }
    .btn-logout:hover{
background: #000;
color: #fff;
cursor: pointer;
    }
    #logo {
        height: 50px;
        padding: 5px 5px 5px 5px;
      }
</style>


<div class="top-nav ">
    <div class="d-flex justify-content-between mx-5">
        <a href="#" class=" btn-default menu-toggle"><img id="logo" src="/image/menu.png" alt="menu"></a>
        <a href="#menu-toggle" class="top-head"> Club - Central Management System</a>
        <a href="#menu-toggle" class=" "  id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false"><img id="logo" src="/image/user.png" alt="menu"></a>
        <ul class="dropdown-menu dropdown-menu-white mt-3 text-center" aria-labelledby="dropdownMenuButton2">
            <img src="/image/user.png" alt="" class="log-img">
            <div class="mt-3">
                <h6>Omor Faruk</h6>
                <p>user</p>
                <a href="#" class="btn-logout">Logout</a>
            </div>
        </ul>
        
    </div>
</div>
