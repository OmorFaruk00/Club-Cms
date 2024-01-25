@extends('layouts.settings')
@section('content')


<form id="accessControlForm" method="POST" action="javaScript:;">
	<div class="card mx-auto mb-3" style="max-width: 640px;">
		<div class="card-header">Create Role</div>
		<div class="card-body">
			<div class="form-group">
                <label for="role_id">Role Name *</label>
              
				<select class="form-control" id="role_id" name="role_id" @change.prevent='getRole'>
					<option selected value="">Select One</option>
					@if(!empty($roles))
					@foreach($roles as $role)
					<option value="{{ $role->id }}">{{ $role->name }}</option>
					@endforeach
					@endif
				</select>
				
				<small id="role_id_help" class="form-text text-danger">&nbsp;</small>
			</div>
			<button type="submit" class="btn-submit" id='storePermissionData'>Save</button>
		</div>
	</div>	

    @if(!empty($permissions->original))	
        @foreach($permissions->original as $group_key => $group_value)
            <div class="card mx-auto mb-3" style="max-width: 640px;">
                <div class="card-header">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{ $group_key }}">
                        <label class="custom-control-label text-capitalize" for="{{ $group_key }}">{{ str_replace("_", " ", $group_key) }}</label>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($group_value as $key => $value)
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input {{ $group_key }}" name="permissions[]" value="{{ $group_key.'.'.$value }}" id="{{ $group_key.'.'.$value }}">
                            <label style="padding-left: 5px" class="custom-control-label text-capitalize" for="{{ $group_key.'.'.$value }}">{{ str_replace("_", " ", $value) }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</form>
{{-- <script type="text/javascript">
    $(document).ready(function () {
            $(document).ready(function() {
            $('#role_id').select2();
        });
        
        var vue = new Vue({
            el: '#app',
            data: {
                config: {
                    base_path: "{{ env('APP_URL')  }}",
                    token: "{{ session('token') }}",
                }, 
                        
                role: '', 
                permission: '',             
            },
           

            methods: {

                getRole(){
                    alert('ok');

                },

       

                storePermissionData() {
                    let data = $('#accessControlForm').serialize();
                    // alert('ok');
                    // console.log(data);

                    let token = this.config.token;                

                        axios.post(`${this.config.base_path}/assign_role_module?token=${token}`, $('#accessControlForm').serialize()).then((response) => {
                            toastr.success('Permission Created Successfully');                           

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

            },

        });

    });


</script> --}}
<script type="text/javascript">
        $(document).ready(function() {
            $(document).ready(function() {
            $('#role_id').select2();
        });

    $("#storePermissionData").click(function(){
			axios.post('{{ env('APP_URL') }}/assign_role_module?token={{ session('token') }}', $('#accessControlForm').serialize())
			.then(function (response) {
				$(".form-text").html("&nbsp;");
				toastr.success('Permission saved.');
			})
			.catch(function (error) {
				$(".form-text").html("&nbsp;");
				$.each(error.response.data, function(index, value){
					$("#" + index + "_help").html(value[0]);
				});
				toastr.error(error.response.data.error);
			});
        });
	

	$("#role_id").change(function(){
		var id = $(this).val();
		axios.get('{{ env('APP_URL') }}/permission/role/'+id+'?token={{ session('token') }}')
		.then(function (response) {
			$('input[type="checkbox"]').prop("checked", false);         
			$.each(response.data.permissions, function(index, value){
				$('input[id="'+value+'"]').prop("checked", true);
				$('input[id="'+value.split('.')[0]+'"]').prop("checked", true);
			});
		})
	});

	$('input[type="checkbox"]').click(function(){

		var id = $(this).attr("id");
		var split = id.split('.');

		if (split.length == 1)
		{
			if ($(this).prop('checked')) {
				$('.'+id+'').prop("checked", true);
			}
			else
			{
				$('.'+id+'').prop("checked", false);
			}
		}
		else
		{
			$('#'+split[0]+'').prop("checked", true);
		}
	})
})
</script>
@endsection
