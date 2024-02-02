@extends('layouts.master')

@section('title', 'home')

@section('content')
<div class="form-bg">   
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-container">
                    <div class="left-content">
                        <div class="login-title">
                            <span class="text-effect">Welcome to </span>
                        <span class="text-effect">  Club-Central Management System</span>
                        </div>
                    </div>
                    <div class="right-content">
                        <img src="/image/diu.png" alt="" class="mb-5">
                        <h3 class="form-title">Login</h3>                     
                        <form class="form-horizontal" @submit.prevent="login">
                            <div class="form-group">
                            <label> Email</label>
                                <input type="email" class="form-control" name="email" id="email" v-model='email'>
                                <div v-if="errors">
                                    <p class="text-danger mt-2" v-if='errors' v-text='errors.office_email[0]'></p>
                                </div>
                            </div>
                            <div class="form-group">
                            <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password" v-model='password'>
                                <p class="text-danger mt-2" v-if='errors' v-text='errors.password[0]'></p>
                            </div>
                            <p class="alert alert-danger mt-4 text-center h6" v-if='error_message'  v-text='error_message'></p>
                            
                            <button class="btn signin">Login</button>
                            <div class="remember-me">
                                <input type="checkbox" class="checkbox" name="remember" id="remember">
                                <label class="check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                            <a href="" class="forgot">Forgot Password</a>
                        </form>
                       

                        <div class="" style="color:red">
                            <p class="" style="color:red">Developed & Powered by: IT-Team, DIU</p>
                            {{-- <p>© {{ Carbon\Carbon::now()->format('Y') }} <a href="https://diu.ac/" target="_blank">Dhaka International University</a></p>
                            <p>Any advice, complaint or query: <a href="mailto:it@diu-bd.net">it@diu-bd.net</a></p> --}}
                        </div>
                      
                        <p class="signup-link">Developed & Powered by: <strong style="color:#248FE3">IT-Team, DIU</strong></p>
                        <p class="signup-link">© {{ Carbon\Carbon::now()->format('Y') }} <strong style="color:#248FE3">Dhaka International University </strong></p>
                    </div>
                </div>
            </div>
        </div>   
</div>

<script>
    new Vue({
        el: '#app',
        data: {
            email: '',
            password: '',           
            message: '',
            errors: '',
            error_message: '',
        },
        methods: {
            login() {
                axios.post('{{ env('APP_URL') }}/auth/login', {
                    email: this.email,
                    password: this.password,
                })
                .then(response => {
                    // console.log(response);
                    window.location.href = "{{ env('APP_URL') }}/app";                  
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
                    if(error.response.status == 401){
                        this.error_message = error.response.data.error;
                        console.log(error.response.data.error);
                    }
                });
            },
        },
        created() {
            
        },
    });
</script>


@endsection