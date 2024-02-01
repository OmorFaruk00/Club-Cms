@extends('layouts.rrc')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 offset-md-2 mt-5">
                <div class="card card-shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mt-2"> Team Create </h5>
                            <a href="{{ route('rrc.team') }}" style="margin-right: 10px"> <img src="/image/list.png"
                                    alt="" height="25px"> </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="name" placeholder="Enter name"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="designation"
                                            placeholder="Enter designation" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label>Profile Link </label>
                                        <input type="text" class="form-control" v-model="profile_link"
                                            placeholder="Enter Profile link" required>
                                    </div>
                                </div>



                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="">File <span class="text-danger">*</span></label> <br>
                                        <input type="file" id="file_input" class="form-control" name="file"
                                            v-on:change="fileValidationCheck">
                                        <br>

                                        <span class="text-danger">File extension must be jpeg,jpg,png,pdf and max file size
                                            1024KB</span>
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
        $(document).ready(function() {
            Vue.use(CKEditor);
            var vue = new Vue({
                el: '#app',
                data: {
                    config: {
                        base_path: "{{ env('APP_URL') }}",
                        token: "{{ session('token') }}",
                    },
                    name: '',
                    designation: '',
                    profile_link: '',

                },

                methods: {

                    storeData() {
                        let token = this.config.token;
                        if (!this.name) {
                            toastr.error("Please enter name");
                            return false;
                        }
                        if (!this.designation) {
                            toastr.error("Please enter designation");
                            return false;
                        }

                        if (document.getElementById('file_input').files[0] == undefined) {
                            toastr.error("Please enter image");
                            return false;
                        }
                        let formData = new FormData();
                        formData.append('name', this.name);
                        formData.append('designation', this.designation);
                        formData.append('profile_link', this.profile_link);
                        formData.append('web', 'rrc');
                        formData.append("file", document.getElementById('file_input').files[0]);

                        axios.post(`${this.config.base_path}/team?token=${token}`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            toastr.success(response.data.message);

                            this.name = '';
                            this.designation = '';
                            this.profile_link = '';
                            $("#file_input").val('');

                        }).catch((error) => {

                            if (error.response.status == 422) {
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
                        let FileSize = document.getElementById('file_input').files[0].size / 1024 /
                        1024; // in MiB // 1MB
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
