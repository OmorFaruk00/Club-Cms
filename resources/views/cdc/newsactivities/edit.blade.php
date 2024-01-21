@extends('layouts.cdc')

@section('title', '')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-sm-12 offset-md-2 mt-5">
                <div class="card card-shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mt-2"> News Activities Update </h5>
                            <a href="{{ route('cdc.news_activities') }}" style="margin-right: 10px"> <img src="/image/list.png"
                                    alt="" height="25px"> </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" v-model="type" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option v-for="(row,index) in types" :key="index" :value="row.value"
                                                v-html="row.text"></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input id="title" type="text" class="form-control" v-model="title"
                                        placeholder="Enter title" required>
                                </div>
                            </div>                            
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <ckeditor v-model="description"></ckeditor>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="">File <span class="text-danger">*</span></label> <br>
                                    <input type="file" id="file_input" class="" name="file"
                                        v-on:change="fileValidationCheck">
                                    <br>

                                    <span class="text-danger">File extension must be jpeg,jpg,png,pdf and max file size
                                        1024KB</span>
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
                        base_path: "{{ env('API_URL') }}",
                        token: "{{ session('token') }}",
                    },
                    title: '',
                    description: '',
                    image_path: '',
                    id: {{ $id }},
                    type:'',
                    types: [
                        {value: 'news', text: 'News'},
                        {value: 'activities', text: 'Activities'},
                        {value: 'courses', text: 'Courses'},
                        {value: 'services', text: 'Services'},
                    ], 
                },

                methods: {

                    storeData() {

                        let token = this.config.token;

                        if (!this.title) {
                            toastr.error("Please enter title");
                            return false;
                        }

                        if (!this.description) {
                            toastr.error("Please enter description");
                            return false;
                        }
                        if (!this.type) {
                            toastr.error("Please enter Type");
                            return false;
                        }                     

                       
                        let formData = new FormData();
                        formData.append('title', this.title);
                        formData.append('description', this.description);
                        formData.append('type', this.type);
                        formData.append('web', 'cdc');
                        formData.append("file", document.getElementById('file_input').files[0]);

                        axios.post(`${this.config.base_path}/news_activities/${this.id}?token=${token}`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            toastr.success(response.data.message);
                            this.fetchDataLists();
                           

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
                    fetchDataLists() {

                        var token = this.config.token;

                        axios.get(
                            `${this.config.base_path}/news_activities/${this.id}?token=${token}`
                            ).then((response) => {
                            this.type = response.data.type;
                            this.title = response.data.title;
                            this.description = response.data.description;
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
                    this.fetchDataLists();
                },

            });

        });
    </script>

@endsection