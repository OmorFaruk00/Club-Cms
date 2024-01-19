@extends('layouts.cdc')

@section('title', '')

@section('content')
    <div class="">

        <div class="card card-shadow">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between">
                    <h5 class="mt-2"> Event list</h5>
                    <a class="btn-submit" href="{{ route('cdc.event.create') }}"> <img src="/image/add.png" alt=""
                            height="18px" style="margin-bottom:4px"> Add New</a>
                </div>
            </div>
            <div class="card-body" >
                <div class="table-responsive" v-if='events.length>0'>
                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(rows, key) in events">
                                <td v-text='key+1'></td>
                                <td v-text='rows.title'></td>
                                <td v-html='rows.description'></td>
                                <td v-text='rows.date'></td>
                                <td> <img :src='rows.image_path' style="width: 125px"></td>
                                <td>
                                    <a href="#" style="margin-right:10px" @click.prevent='editItem(rows.id)'><img
                                            src="/image/edit.png" alt="" height="30px"></a>
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
                events: '',
                config: {
                    base_path: "{{ env('APP_URL') }}",
                    token: "{{ session('token') }}",
                },

            },
            methods: {
                getData() {
                    axios.get('{{ env('APP_URL') }}/cdc/event_list')
                        .then(response => {
                            this.events = response.data;
                        })
                        .catch(error => {
                            console.log(error)

                        });
                },
                editItem(id) {
                    toastr.success('Verified');
                },
                deleteItem(id) {

                    if (confirm("Do you really want to delete?")) {

                        var token = this.config.token;

                        axios.get(`${this.config.base_path}/cdc/event_delete/${id}?token=${token}`).then(
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
