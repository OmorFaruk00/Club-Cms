


@extends('layouts.master')

@section('title', 'home')

@section('content')
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
   

<div class="top-nav" >
    
    <div class="d-flex justify-content-between mx-5">
        <p class="text-danger"></p>
        <a href="#" class=" btn-default menu-toggle"><img id="logo" src="/image/menu.png" alt="menu"></a>
        <a href="#menu-toggle" class="top-head"> Club - Central Management System</a>
        <a href="#menu-toggle" class=" "  id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false"><img id="logo" src="/image/user.png" alt="menu"></a>
        <button class="btn-logout" @click.prevent="logout">Logout</button>
        <ul class="dropdown-menu dropdown-menu-white mt-3 text-center" aria-labelledby="dropdownMenuButton2">
            <img src="/image/user.png" alt="" class="log-img">
            <div class="mt-3">
                <h6>Omor Faruk</h6>
                <p>user</p>
                <button type="button" class="btn-logout" on-click="logout">Logout</button>
            </div>
        </ul>
        
    </div>
</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
<script>
    new Vue({
        el: '#app',
        data: {
            email: 'omorfaruk.it@diu.ac',
            password: 'Omor@6669',
           
            message: '',
            errors: '',
            error_message: '',
        },
        methods: {
            logout() {
                // alert('ok');
                axios.post('https://api.diu.ac/auth/login', {
                    office_email: this.email,
                    password: this.password,
                })
                .then(response => {
                    axios.post('{{ env('APP_URL') }}/login', { token: response.data.token})
                .then(function (response) {
                    console.log(response);
                    window.location.href = "{{ env('APP_URL') }}/app";
                })
                .catch(function (error) {
                    toastr.error(error.response.data.error);
                });

                    // sessionStorage.setItem('token', response.data.token);
                    // window.location.href = '/app';
                })
                .catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data;
                        console.log(error.response.data);
                    }
                    
                    if(error.response.status == 400){
                        this.error_message = error.response.data.error;
                        console.log(error.response.data.error);
                    }
                });
            },
            logossssut(){
                alert('ok');
                console.log('Logout clicked!');

            }
        },
        created() {
            
            
        },
    });
</script>
@endsection