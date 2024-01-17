@extends('layouts.master')

@section('title', 'home')

@section('content')
<style>
      
        .bg {
            /* background: #e7e7e7; */
            background-image: url('image/bg.jpg');
    background-size: cover; /* Adjust the background size as needed */
    background-position: center center; /* Adjust the background position as needed */
    background-repeat: no-repeat; 
    height: 100vh;
        }
        .form-container {
            background-color: #fff;
            font-family: "Titillium Web", sans-serif;
            padding: 25px 10px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            margin-top: 40%;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        }
        .form-container:before {
            content: "";
            background: radial-gradient(at 50% 25%, #1093ea 0%, #007bb7 100%);
            height: 70%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            z-index: -1;
            clip-path: polygon(0 0, 100% 0%, 100% 100%, 0 75%);
        }
        .form-container .form-icon {
            color: #fff;
            font-size: 55px;
            line-height: 55px;
            text-align: center;
            margin: 0 0 10px;
        }
        .form-container .title {
            color: #fff;
            font-size: 33px;
            font-weight: 500;
            text-align: center;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            margin: 0 0 25px;
        }
        .form-container .form-horizontal {
            background: #fff;
            padding: 10px;
            margin: 0 0 20px;
            box-shadow: 0 0 7px rgba(0, 0, 0, 0.3);
            border-radius: 3px;
        }
        .form-horizontal .form-group {
            background-color: #fff;
            margin: 0 0 15px;
            border-radius: 3px;
            border-bottom: 1px solid #ddd;
        }
        .form-horizontal .form-group:nth-child(3) {
            margin-bottom: 40px;
        }
        .form-horizontal .input-icon {
            color: #007bb7;
            font-size: 22px;
            text-align: center;
            line-height: 43px;
            height: 45px;
            width: 25px;
            margin: 0 0 0 4px;
            vertical-align: top;
            display: inline-block;
        }
        .form-horizontal .form-control {
            color: #555;
            background-color: transparent;
            font-size: 20px;
            letter-spacing: 1px;
            width: calc(100% - 33px);
            height: 45px;
            padding: 0 5px;
            box-shadow: none;
            border: none;
            border-radius: 0;
            display: inline-block;
            transition: all 0.3s;
        }
        .form-horizontal .form-control:focus {
            box-shadow: none;
            border: none;
        }
        .form-horizontal .form-control::placeholder {
            color: #999;
            font-size: 20px;
            font-weight: 300;
            text-transform: capitalize;
        }
        .form-horizontal .forgot-pass {
            font-size: 16px;
            font-weight: 500;
            text-align: right;
            margin: 0 0 15px 0;
            display: block;
            color: #007bb7;
            padding: 10px 5px;
        }
        
        .form-horizontal .forgot-pass:hover {
            color: #555;
            cursor: pointer;
        }
        .form-horizontal .btn {
            color: #fff;
            background: #007bb7;
            font-size: 20px;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 1px;
            width: 100%;
            padding: 5px 15px 5px;
            margin-top: 20px;
            border: none;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        .form-horizontal .btn:hover,
        .form-horizontal .btn:focus {
            color: #fff;
            background-color: #007bb7;
            letter-spacing: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3), 0 0 10px rgba(0, 0, 0, 0.3) inset;
            outline: none;
        }
        .form-container .user-signup {
            color: #333;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            display: block;
        }
        .form-container .user-signup a {
            color: #007bb7;
            transition: all 0.3s ease 0s;
        }
        .form-container .user-signup a:hover {
            color: #555;
            text-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
        }
        </style>


<div class="bg">
    <div class="form-bg" >
        <div class="container">
            
            <div class="row">
                
                <div class="col-md-offset-4 col-md-4 col-sm-12 mx-auto">
                    <div class="form-container">
                        <div class="form-icon">
                            <i class="fa fa-user-edit"></i>
                        </div>
                        <h3 class="title">User Login</h3>
                        <form
                            class="form-horizontal"
                            
                        >
                            <div class="form-group mt-4">
                                <span class="input-icon"
                                    ><i class="fa fa-user"></i
                                ></span>
                                <input
                                    class="form-control"
                                    type="email"
                                    placeholder="Username" v-model="auth.form.email"
                                   
                                />
                            </div>
                            <div class="form-group">
                                <span class="input-icon"
                                    ><i class="fa fa-lock"></i
                                ></span>
                                <input
                                    class="form-control"
                                    type="password"
                                    placeholder="Password"  v-model="auth.form.password"
                                   
                                />
                            </div>
                            <button type="submit" class="btn signin" @click="login()">
                                Login
                            </button>
                            <span
                                ><nuxt-link to="" class="forgot-pass"
                                    >Forgot Password</nuxt-link
                                ></span
                            >
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection