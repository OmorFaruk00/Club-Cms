@extends('layouts.settings')

@section('title', 'role')

@section('content')
<div class="">

    <div class="card card-shadow">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <h5 class="mt-2"> Role list</h5>
                <a class="btn-submit" href="#" data-bs-toggle="modal" data-bs-target="#addModal"> <img
                        src="/image/add.png" alt="" height="18px" style="margin-bottom:4px"> Add New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered " v-if='roles.length>0'>
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(rows, key) in roles">
                            <td v-text='key+1'></td>
                            <td v-text='rows.name'></td>
                            <td>
                                <a @click.prevent="editData(rows.id)" style="margin-right:10px"><img
                                        src="/image/edit.png" alt="" height="30px"></a>

                            </td>

                        </tr>


                    </tbody>
                </table>
                <div v-else>
                    <h4 class="text-center text-danger">No Data Available</h4>

                </div>
            </div>

        </div>
    </div>
    <div class="container mt-3">


        <!-- The Add Modal -->
        <div class="modal" id="addModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Create Role</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Role Name <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control" v-model="name" placeholder="Enter title"
                                required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn-submit" @click.prevent="storeRole">Submit</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- The Add Modal -->
        <div class="modal" id="updateModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Update Role</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Role Name <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control" v-model="name" placeholder="Enter title"
                                required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn-submit" @click.prevent="updateRole">Update</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        new Vue({
                el: '#app',
                data: {
                    config: {
                        base_path: "{{ env('API_URL') }}",
                        token: "{{ session('token') }}",
                    },
                    name: '',
                    id:'',
                    roles: [],

                },

                methods: {

                    storeRole() {
                        var token = this.config.token;
                        if(!this.name){
                            toastr.error("Please Enter Name");

                        }
                        axios.post(`${this.config.base_path}/setting/role?token=${token}`, {
                                'name': this.name
                            })
                            .then(response => {
                                toastr.success(response.data.message);
                                this.getData();
                                $('#addModal').modal('hide');
                                this.name= '';
                            })
                            .catch(error => {
                                console.log(error)

                            });
                    },
                    updateRole() {
                        const $id = this.id; 
                        var token = this.config.token;
                        if(!this.name){
                            toastr.error("Please Enter Name");

                        }
                        axios.put(`${this.config.base_path}/setting/role/${$id}?token=${token}`, {
                                'name': this.name
                            })
                            .then(response => {
                                toastr.success(response.data.message);
                                $('#updateModal').modal('hide');
                                this.getData();
                                this.name= '';
                            })
                            .catch(error => {
                                console.log(error)

                            });
                    },
                    editData(id) {
                        const $id = id;                        
                        var token = this.config.token;
                        axios.get(`${this.config.base_path}/setting/role/${$id}/edit?token=${token}`).then(
                            (response) => {
                                this.name = response.data.name;
                                this.id = response.data.id;
                                console.log(response)
                                $('#updateModal').modal('show');
                            }).catch((error) => {
                            toastr.error("There was something wrong");
                        });



                    },

                    getData() {
                        var token = this.config.token;
                        axios.get(`${this.config.base_path}/setting/role?token=${token}`).then(
                            (response) => {
                                this.roles = response.data;
                                console.log(response)
                            }).catch((error) => {
                                if(error.response.status == 401){
                                   toastr.error(error.response.data.error);
                                 }else{

                                  toastr.error('Something Went wrong')
                                 }
                        });
                    },

                },
                created() {
                    this.getData();
                    // alert('ok');
                },

            });
    </script>

    @endsection