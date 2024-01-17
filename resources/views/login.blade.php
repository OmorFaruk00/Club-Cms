@extends('layouts.master')

@section('title', 'home')

@section('content')
<div class="form-bg">
    <div class="">
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
                        <form class="form-horizontal">
                            <div class="form-group">
                            <label> Email</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="form-group">
                            <label>Password</label>
                                <input type="password" class="form-control">
                            </div>
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
</div>

@endsection