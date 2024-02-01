@extends('layouts.cdc')
@section('content')
    <div>
        <div class="card card-shadow">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between">
                    <h5 class="mt-2"> Event list</h5>
                    <a class="btn-submit" href="{{ route('cdc.event.create') }}"> <img src="/image/add.png" alt=""
                            height="18px" style="margin-bottom:4px"> Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" v-if='events.length>0'>
                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                {{-- <th scope="col">Date</th> --}}
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(rows, key) in events">
                                <td v-text='key+1'></td>
                                <td v-text='rows.title'></td>
                                <td v-html='rows.description'></td>
                                {{-- <td v-text='rows.date'></td> --}}
                                <td> <img :src='rows.image_path' style="width: 125px;height:60px"></td>
                                <td style="width: 100px">
                                    <a :href="'{{ url('cdc/event') }}' + '/' + rows.id + '/edit'"
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
                events: '',
                type: 'cdc',
                config: {
                    base_path: "{{ env('API_URL') }}",
                    token: "{{ session('token') }}",
                },

            },
            methods: {
                getData() {
                    var token = this.config.token;
                    axios.get(`${this.config.base_path}/event_list/${this.type}?token=${token}`)
                        .then(response => {
                            this.events = response.data;
                        })
                        .catch(error => {
                            
                            if(error.response.status == 401){
                                toastr.error(error.response.data.error);
                            }else{

                                toastr.error('Something Went wrong')
                            }
                        });
                },

                deleteItem(id) {

                    if (confirm("Do you really want to delete?")) {

                        var token = this.config.token;

                        axios.delete(`${this.config.base_path}/event/${id}?token=${token}`).then(
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
