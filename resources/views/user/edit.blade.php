@extends('shared._layout')

@section('title', 'Users')

@section('styles')
	{!! HTML::style('css/jake-custom-styles.css') !!}
	
@endsection

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="col-md-3 panel panel-heading panel-primary" style="margin: 0 0 0 100px;">
<h3>Edit User:</h3>

<?php
	$user_id = $users->id;
	$user_name = $users->name;
	$user_email = $users->email;
	$user_password = $users->password;
	$user_role = $users->role_name;
?>

 <form name="edituser" method="post" action="{{ url('user/edit/'.$user_id)}}">
   <div class="panel panel-default panel-body">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT">
	<input type="hidden" name="record_changed" id="record_changed" class="watch-user-changes" value="0" />
	<div>
		<span style="color:red;">* </span>User Name :
		<input type="text" name="name" placeholder="User Name" value="{{ $user_name }}" class="form-control" /><br />
	</div>
	<div>
		<span style="color:red;">* </span>E-mail :
		<input type="email" name="label_email" placeholder="E-mail" value="{{ $user_email }}" class="form-control" disabled/>
		<input type="hidden" name="email" placeholder="E-mail" value="{{ $user_email }}" class="form-control"/><br />
	</div>
	<div>
		<span style="color:red;">* </span>Password :
		<input type="password" name="password" placeholder="Password" class="form-control" /><br />
	</div>
	<div>
		<span style="color:red;">* </span>Confirm password :
		<input type="password" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" class="form-control" required/><br />
	</div>
	<div class="form-group between">
      <label>
	   Role:
	  </label>
	    <select class="form-control" name="role_desc" value="$user_role" style="width:150px; padding: 5px;">
          <!--option value=""></option-->
		@foreach($roles as $role)
		  <option {{ $role->role_id == $users->role_id ? 'selected' : null }} value="{{ $role->role_id }}">{{ $role->role_name }}</option>
		@endforeach
        </select>
	</div>
   </div>
   <div style="float:right;">
	<input type="button" value="Cancel" onclick="window.location='{{ url('user/index') }}'" />
	<input type="submit" value="Submit" />
   </div>
 </form>

</div>
@endsection

@section('scripts')
<script>
	var $productChanged=$('#record_changed');

	$(document).on("change", ".watch-user-changes", function(event){
		$productChanged.val(1);
	});
</script>		
@endsection