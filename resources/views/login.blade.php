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
                                <input type="checkbox" class="checkbox">
                                <span class="check-label">Remember Me</span>
                            </div>
                            <a href="" class="forgot">Forgot Password</a>
                        </form>
                        <span class="separator">OR</span>
                        <ul class="social-links">
                            <li><a href=""><i class="fab fa-google"></i> Login with Google</a></li>
                            <li><a href=""><i class="fab fa-facebook-f"></i> Login with Facebook</a></li>
                        </ul>
                        <span class="signup-link">Don't have an account? Sign up <a href="">here</a></span>
                    </div>
                </div>
            </div>
        </div>   
</div>

<script>
    new Vue({
        el: '#app',
        data: {
            email: 'admin@gmail.com',
            password: 'Admin@1234',           
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
                });
            },
        },
        created() {
            
        },
    });
</script>


@endsection