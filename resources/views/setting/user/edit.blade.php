@extends('layouts.settings')

@section('title', 'user update')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-sm-12 offset-md-2 mt-5">
            <div class="card card-shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-2"> User Update </h5>
                        <a href="{{ route('setting.user_index') }}" style="margin-right: 10px"> <img
                                src="/image/list.png" alt="" height="25px"> </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="userFrom">



                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="name" placeholder="Enter name"
                                        required>
                                    <span class="text-danger" v-if="errors.name" v-text="errors.name[0]"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" v-model="email" placeholder="Enter Email"
                                        required>
                                    <span class="text-danger" v-if="errors.email" v-text="errors.email[0]"></span>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label> Phone <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" v-model="phone" placeholder="Enter phone"
                                        required>
                                    <span class="text-danger" v-if="errors.phone" v-text="errors.phone[0]"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="role_id">Role <span class="text-danger">*</span></label>

                                    <select v-model="role_id" class="form-control" id="role_id" >
                                        <option v-for="(row,index) in roles" :key="index" :value="row.id"
                                            v-html="row.name"></option>
                                    </select>
                                    <span class="text-danger" v-if="errors.role_id" v-text="errors.role_id[0]"></span>

                                </div>
                            </div>

                            <div class="col-lg-8 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="">File <span class="text-danger">*</span></label> <br>
                                    <input type="file" id="file_input" class="form-control" name="file"
                                        v-on:change="fileValidationCheck">
                                    <br>

                                    <span class="text-danger">File extension must be jpeg,jpg,png,pdf and max file size
                                        1024KB</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 mt-3">
                                <img :src='image_path' style="width:125px;height:100px">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn-submit" @click.prevent='updateData'>Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
            $(document).ready(function() {
                $('#role_id').select2();
            });
            var vue = new Vue({
                el: '#app',
                data: {
                    config: {
                        base_path: "{{ env('API_URL') }}",
                        token: "{{ session('token') }}",
                    },

                    id: {{ $id }},

                    errors: [],
                    roles: [],                    
                        name: '',
                        email: '',
                        role_id: '',
                        phone: '',
                        image_path:'',
                    
                },

                methods: {

                    updateData() {
                        let token = this.config.token;

                        let formData = new FormData();
                        formData.append('name', this.name);
                        formData.append('email', this.email);
                        formData.append('phone', this.phone);
                        formData.append('role_id', document.getElementById('role_id').value);
                        formData.append("file", document.getElementById('file_input').files[0]);
                        console.log(formData);

                        axios.post(`${this.config.base_path}/user/${this.id}?token=${token}`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            toastr.success(response.data.message);
                            this.fetchData();                         

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


                    fetchData() {
                        var token = this.config.token;
                        axios.get(
                            `${this.config.base_path}/user/${this.id}?token=${token}`
                        ).then((response) => {
                            console.log(response);
                            this.name = response.data.name;
                            this.email = response.data.email;
                            this.phone = response.data.phone;
                            this.role_id = response.data.role_id;
                            this.image_path = response.data.image;
                        }).catch((error) => {

                            if (error.response.status == 400) {
                                toastr.error(error.response.data.message);
                                return false;
                            }

                            toastr.error("Something went wrong");

                        });
                    },

                    fetchRole() {

                        var token = this.config.token;
                        axios.get(
                            `${this.config.base_path}/setting/role?token=${token}`
                        ).then((response) => {
                            this.roles = response.data;

                        }).catch((error) => {

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
                created() {
                    this.fetchData();
                    this.fetchRole();
                    // alert('ok');
                },

            });

        });
</script>

@endsection