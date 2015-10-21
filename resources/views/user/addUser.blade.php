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
<h3>Create User:</h3>

 <form method="post" action="{{ url('user/create') }}">
   <div class="panel panel-default panel-body">
	{{ csrf_field() }}
	<div>
		<span style="color:red;">* </span>User Name : 
		<input type="text" name="name" placeholder="User Name" value="{{ old('name') }}" class="form-control" /><br />
	</div>
	<div>
		<span style="color:red;">* </span>E-mail : 
		<input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" class="form-control" /><br />
	</div>
	<span style="color:red;">* </span>Password : 
	<div>
		<input type="password" name="password" placeholder="Password" class="form-control" /><br />
	</div>
	<span style="color:red;">* </span>Confirm Password : 
	<div>
		<input type="password" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" class="form-control" required/>
	</div><br />
	<div class="form-group">
      <label>
	   <span style="color:red;">* </span>Role:
	  </label>
	    <select class="form-control" name="role_desc" style="width:150px; padding: 5px;">
		  <option value=""></option>
        @foreach($roles as $role)
		  <option value="{{$role->role_id}}">{{$role->role_name}}</option>
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