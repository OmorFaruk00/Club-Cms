@extends('layouts.rrc')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 offset-md-2 mt-5">
                <div class="card card-shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mt-2"> Team Update </h5>
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
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <img :src='image_path' style="width: 150px;height:150px">
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
            Vue.use(CKEditor);
            var vue = new Vue({
                el: '#app',
                data: {
                    config: {
                        base_path: "{{ env('API_URL') }}",
                        token: "{{ session('token') }}",
                    },
                    name: '',
                    designation: '',
                    profile_link: '',
                    id: {{ $id }},
                },

                methods: {

                    updateData() {

                        let token = this.config.token;

                        if (!this.name) {
                            toastr.error("Please enter name");
                            return false;
                        }
                        if (!this.designation) {
                            toastr.error("Please enter designation");
                            return false;
                        }


                        let formData = new FormData();
                        formData.append('name', this.name);
                        formData.append('designation', this.designation);
                        formData.append('profile_link', this.profile_link);
                        formData.append("file", document.getElementById('file_input').files[0]);
                        axios.post(`${this.config.base_path}/team/${this.id}?token=${token}`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            toastr.success(response.data.message);
                            this.fetchData();

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
                    fetchData() {
                        var token = this.config.token;
                        axios.get(
                            `${this.config.base_path}/team/${this.id}?token=${token}`
                        ).then((response) => {
                            this.name = response.data.name;
                            this.designation = response.data.designation;
                            this.profile_link = response.data.profile_link;
                            this.image_path = response.data.image_path;

                        }).catch((error) => {

                            if (error.response.status == 400) {
                                toastr.error(error.response.data.message);
                                return false;
                            }

                            toastr.error("Something went wrong");

                        });
                    },

                },
                created() {
                    this.fetchData();
                },

            });

        });
    </script>
@endsection
