@extends('layouts.settings')
@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-sm-12 offset-md-2 mt-5">
            <div class="card card-shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-2">Change Password </h5>
                        <a href="{{route('setting.user_index')}}" style="margin-right: 10px"> <img src="/image/list.png"
                                alt="" height="25px"> </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="userFrom">



                        <div class="row">


                            <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>Old Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="user.old_password"
                                        placeholder="Enter Old Password" required>
                                    <span class="text-danger" v-if="errors.old_password"
                                        v-text="errors.old_password[0]"></span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>New Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="user.password"
                                        placeholder="Enter New Password" required>
                                    <span class="text-danger" v-if="errors.password" v-text="errors.password[0]"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label> Confirm Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="user.password_confirmation"
                                        placeholder="Enter Confirm Password" required>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="card-footer">
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn-submit" @click.prevent='storeData'>Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).ready(function() {
            $('#role_id').select2();
        });

        var vue = new Vue({
            el: '#app',
            data: {
                config: {
                    base_path: "{{ env('APP_URL')  }}",
                    token: "{{ session('token') }}",
                },
                user:{
                    old_password: '',
                     password: '',
                    password_confirmation: '',  

                },               
          
                          
                errors:[],
               
            },
           

            methods: {
             

                storeData() {
                    let token = this.config.token;                                    

                        axios.post(`${this.config.base_path}/setting/change_password?token=${token}`, this.user).then((response) => {
                            toastr.success(response.data.message);                                                 
                          

                        }).catch((error) => {

                            if (error.response.status == 422) {
                                console.log(error.response.data.errors);                                
                                this.errors = error.response.data.errors
                                
                                toastr.error('Validation error');
                                return false;
                            }

                            if (error.response.status == 400) {
                                toastr.error(error.response.data.error);
                                return false;
                            }

                            toastr.error("Something went wrong");

                        });


                },

               

            },

        });

    });


</script>

@endsection