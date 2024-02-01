@extends('layouts.yec')
@section('content')
<div>
    <div class="card card-shadow">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <h5 class="mt-2"> News Activities list</h5>
                <a class="btn-submit" href="{{ route('yec.news_activities.create') }}"> <img src="/image/add.png" alt=""
                        height="18px" style="margin-bottom:4px"> Add New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" v-if='news_activitiess.length>0'>
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Type</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(rows, key) in news_activitiess">
                            <td v-text='key+1'></td>
                            <td style="text-transform:capitalize" v-text='rows.type'></td>
                            <td v-text='rows.title'></td>
                            <td v-html='rows.description'></td>
                            <td> <img :src='rows.image_path' style="width: 125px;height:60px"></td>
                            <td width='100px'>
                                <a :href="'{{ url('yec/news_activities') }}' + '/' + rows.id + '/edit'"
                                    style="margin-right:10px"><img src="/image/edit.png" alt="" height="30px"></a>
                                <a href="#" @click.prnews_activities='deleteItem(rows.id)'><img src="/image/delete.png"
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
                news_activitiess: '',
                type: 'yec',
                config: {
                    base_path: "{{ env('API_URL') }}",
                    token: "{{ session('token') }}",
                },

            },
            methods: {
                getData() {
                    var token = this.config.token;
                    axios.get(`${this.config.base_path}/news_activities_list/${this.type}?token=${token}`)
                        .then(response => {
                            this.news_activitiess = response.data;
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

                        axios.delete(`${this.config.base_path}/news_activities/${id}?token=${token}`).then(
                            (response) => {

                                toastr.success(response.data.message);
                                this.getData();

                            }).catch((error) => {
                                if(error.response.status == 401){
                                   toastr.error(error.response.data.error);
                                 }else{

                                  toastr.error('Something Went wrong')
                                 }
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