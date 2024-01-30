@extends('layouts.settings')
@section('content')


<form id="accessControlForm" method="POST" action="javaScript:;">
	<div class="card mx-auto mb-3" style="max-width: 640px;">
		<div class="card-header">Assign Special Permission</div>
		<div class="card-body">
			<div class="form-group">
                <label for="role_id">Role Name *</label>
              
				<select class="form-control" id="user_id" name="user_id" @change.prevent='getRole'>
					<option selected value="">Select One</option>
					@if(!empty($users))
					@foreach($users as $user)
					<option value="{{ $user->id }}">{{ $user->name }}</option>
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

<script type="text/javascript">
        $(document).ready(function() {
            $(document).ready(function() {
            $('#role_id').select2();
        });

    $("#storePermissionData").click(function(){
			axios.post('{{ env('APP_URL') }}/assign_module_permission?token={{ session('token') }}', $('#accessControlForm').serialize())
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
	

	$("#user_id").change(function(){		
		var id = $(this).val();
		axios.get('{{ env('APP_URL') }}/permission/user/'+id+'?token={{ session('token') }}')
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
