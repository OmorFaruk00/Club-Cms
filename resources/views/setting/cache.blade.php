@extends('layouts.settings')
@section('content')

<div class="">

    <div class="card card-shadow">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between">
                <h5 class="mt-2"> Cache Clear</h5>
                
            </div>
        </div>
        <div class="card-body">

            <div class="row my-5">
                <div class="col-lg-2 col-md-3 col-sm-6" v-for="(row,index) in websiteData" :key="index">
                    <div>
                        
                        <button class="cache-btn" @click="cacheClear(row.url)" v-text='row.name'> </button>
                    </div>                   

                    
                </div>
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
                websiteData: [
                        {name: 'club api', url: 'https://club-api.diu.ac.bd'},
                        {name: 'club cms', url: 'https://club-cms.diu.ac.bd'},
                        {name: 'cdc', url: 'https://cdc.diu.ac.bd'},
                        {name: 'rrc', url: 'https://rrc.diu.ac.bd'},
                        {name: 'yec', url: 'https://yec.diu.ac.bd'},
                    
                    ]

            },
            methods: {
                cacheClear(url) {
                    axios.get(`${url}/cache-clear`)
                        .then((response) => {

                            toastr.success(response.data.message);

                        }).catch((error) => {

                        if (error.response.status == 400) {
                            toastr.error(error.response.data.error);
                            return false;
                        } else {
                            toastr.error("Something went wrong");
                        }

                    });


                    },

                
            },
           

        });
    </script>

@endsection
