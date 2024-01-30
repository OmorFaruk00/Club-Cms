@extends('layouts.settings')

@section('title', 'user')

@section('content')
    <div class="">

        <div class="card card-shadow">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between">
                    <h5 class="mt-2"> User list</h5>
                    <a class="btn-submit" href="{{ route('user.create') }}"> <img src="/image/add.png" alt=""
                            height="18px" style="margin-bottom:4px"> Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" v-if='users.length>0'>
                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(rows, key) in users">
                                <td v-text='key+1'></td>
                                <td v-text='rows.name'></td>
                                <td v-html='rows.email'></td>
                                <td v-html='rows.phone'></td>
                                <td v-html='rows.role'></td>
                                <td v-html='rows.created_by'></td>
                                <td> <img :src='rows.image_path' style="width: 125px"></td>
                                <td>
                                    <a :href="'{{ url('setting/user') }}' + '/' + rows.id + '/edit'"
                                        style="margin-right:10px"><img src="/image/edit.png" alt=""
                                            height="30px"></a>
                                    <a href="#" @click.prevent='deleteItem(rows.id)'><img src="/image/delete.png"
                                            alt="" height="30px"></a>
                                </td>

                            </tr>


                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h4 class="text-center text-danger">No Data Available</h4>

                </div>
            </div>
        </div>

    </div>
    <script>
        new Vue({
            el: '#app',
            data: {
                users: '',
                config: {
                    base_path: "{{ env('API_URL') }}",
                    token: "{{ session('token') }}",
                },

            },
            methods: {
                getData() {
                    var token = this.config.token;
                    axios.get(`${this.config.base_path}/setting/user/list?token=${token}`)
                        .then(response => {
                            console.log(response.data.data);
                            this.users = response.data.data;
                        })
                        .catch(error => {
                            console.log(error)

                        });
                },

                deleteItem(id) {

                    if (confirm("Do you really want to delete?")) {

                        var token = this.config.token;

                        axios.delete(`${this.config.base_path}/setting/user/${id}?token=${token}`).then(
                            (response) => {

                                toastr.success(response.data.message);
                                this.getData();

                            }).catch((error) => {
                            toastr.error("There was something wrong");
                        });

                    }
                },

            },
            created() {
                this.getData();
            },

        });
    </script>

@endsection
