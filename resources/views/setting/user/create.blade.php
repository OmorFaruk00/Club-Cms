@extends('layouts.settings')
@section('content')
<div class="container">
    
    <div class="row">
        <div class="col-md-8 col-sm-12 offset-md-2 mt-5">
            <div class="card card-shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-2"> User Create  </h5>
                        <a href="{{route('setting.user_index')}}" style="margin-right: 10px"> <img src="/image/list.png" alt="" height="25px"> </a>
                       </div>
                </div>
                <div class="card-body">
                    <form id="userFrom">

                     

                       <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="form-group">
                                <label >Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" v-model="name"
                                       placeholder="Enter name" required>
                                       <span class="text-danger" v-if="errors.name" v-text="errors.name[0]"></span>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input  type="email" class="form-control" v-model="email"
                                       placeholder="Enter Email" required>
                                       <span class="text-danger" v-if="errors.email" v-text="errors.email[0]"></span>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" v-model="password"
                                       placeholder="Enter Password" required>
                                       <span class="text-danger" v-if="errors.password" v-text="errors.password[0]"></span>
                            </div>
                        </div> 
                       
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="form-group">
                                <label > Confirm Password <span class="text-danger">*</span></label>
                                <input  type="text" class="form-control" v-model="confirm_password"
                                       placeholder="Enter Password" required>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="form-group">
                                <label > Phone <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" v-model="phone"
                                       placeholder="Enter phone" required>
                                       <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="role_id">Role*</label>
                              
                                <select class="form-control" id="role_id"  v-model='role_id' >
                                    <option selected value="">Select One</option>
                                    @if(!empty($roles))
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" v-if="errors.role_id" v-text="errors.role_id[0]"></span>
                                
                            </div>
                            </div>                      
                       
                      

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="">File <span class="text-danger">*</span></label> <br>
                                <input type="file" id="file_input" class="form-control" name="file"
                                       v-on:change="fileValidationCheck">
                                <br>

                                <span class="text-danger">File extension must be jpeg,jpg,png,pdf and max file size 1024KB</span>
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
                name: '',              
                email: '',
                password: '',
                confirm_password: '',
                role_id:'',
                phone:'',
                errors:[]
               
            },
            // created() {
            //     alert('ok');
            // },

            methods: {
                getRole(){
                    console.log('ok');
                    alert('ok');

                },

                storeData() {
                    let token = this.config.token;
                    if (this.password !== this.confirm_password) {
                        toastr.error("Confirm password doesn't match");
                        return false;
                    }                                 

                    if (document.getElementById('file_input').files[0] == undefined) {
                        toastr.error("Please enter image");
                        return false;
                    }
                    let formData = new FormData();
                        formData.append('name', this.name);
                        formData.append('email', this.email);
                        formData.append('password', this.password);
                        formData.append('phone', this.phone);
                        formData.append('role_id', document.getElementById('role_id').value);
                        formData.append("file", document.getElementById('file_input').files[0]);

                        axios.post(`${this.config.base_path}/user?token=${token}`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            toastr.success(response.data.message);

                            this.name = '';                          
                            this.passsword = '';                          
                            this.confirm_password = '';                          
                            this.email = '';                          
                            this.phone = '';                          
                            this.role_id = '';                          
                            $("#file_input").val('');

                        }).catch((error) => {

                            if (error.response.status == 422) {
                                
                                this.errors = error.response.data.errors
                                toastr.error('Validation error');
                                return false;
                            }

                            if (error.response.status == 400) {
                                toastr.error(error.response.data.message);
                                return false;
                            }

                            toastr.error("Something went wrong");

                        });


                },

                fileValidationCheck() {
                    let formData = new FormData();
                    let FileSize = document.getElementById('file_input').files[0].size / 1024 / 1024; // in MiB // 1MB
                    if (FileSize > 1) {
                        alert('File max size must be 1024KB');
                        $("#file_input").val('');
                        return false;
                    }
                },

            },

        });

    });


</script>

@endsection